<?php

namespace App\Controllers;

use App\Entities\Acl;
use App\Entities\Bill;
use CodeIgniter\Database\Exceptions\DataException;
use stdClass;

class BillController extends BaseController
{
    public function index()
    {
        if (!current_user_can(Acl::VIEW_BILLS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $print = (int)$this->request->getGet('print');

        $session = session();
        $filter = $session->get('bill_filter');
        if (!$filter) {
            $filter = new stdClass;
        }
        if (!isset($filter->status)) {
            $filter->status = 0;
        }
        if (!isset($filter->year)) {
            $filter->year = date('Y');
        }
        if (!isset($filter->month)) {
            $filter->month = 0;
        }
        
        if (($year = $this->request->getGet('year')) != null) {
            $filter->year = $year;
        }

        if (($month = $this->request->getGet('month')) != null) {
            $filter->month = $month;
        }

        if ($filter->month < 0 || $filter->month > 12) {
            $filter->month = 0;
        }

        if (($status = $this->request->getGet('status')) != null) {
            $filter->status = $status;
        }

        $session->set('bill_filter', $filter);

        $where = [];
        $where[] = 'b.company_id=' . current_user()->company_id;
        $where[] = 'year(date)=' . $filter->year;
        if ($filter->month != 0) {
            $where[] = 'month(date)=' . $filter->month;
        }
        if ($filter->status != 'all') {
            $where[] = 'b.status=' . (int)$filter->status;
        }

        $where = implode(' and ', $where);
        if (!empty($where)) {
            $where = ' where ' . $where;
        }

        $sql = "select
            b.*, c.fullname, c.wa, c.address, c.cid, p.name product_name
            from bills b
            inner join customers c on b.customer_id = c.id
            left join products p on b.product_id = p.id 
            $where
            order by c.cid asc";
        $items = $this->db->query($sql)->getResultObject();

        $view = 'index';
        if ($print) {
            $view = 'print-list';
        }

        return view("bill/$view", [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function generate()
    {
        if (!current_user_can(Acl::GENERATE_BILLS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data = new stdClass;
        $data->year = date('Y');
        $data->month = date('m');
        $data->due_date = 20;

        if ($this->request->getMethod() == 'post') {
            $billModel = $this->getBillModel();

            $data->year = (int)$this->request->getPost('year');
            $data->month = (int)$this->request->getPost('month');
            $data->due_date = (int)$this->request->getPost('due_date');

            //TODO: VALIDASI

            $data->month = str_pad($data->month, 2, '0', STR_PAD_LEFT);
            $date = "$data->year-$data->month-01";
            $due_date = "$data->year-$data->month-$data->due_date";

            // check duplikat tagihan
            $result = $this->db->query('
                select * from bills
                where date=:date: and company_id=' . current_user()->company_id, [
                'date' => $date
            ])->getResultObject();

            $itemsByCodes = [];
            foreach ($result as $item) {
                $itemsByCodes[$item->code] = $item;
            }

            $customers = $this->getCustomerModel()->getAllActive();
            $this->db->transBegin();
            foreach ($customers as $customer) {
                if (!$customer->product_id)
                    continue;
                
                $code = 'INV-' . current_user()->company_id . '-' . date('Ym', strtotime($date)) . '-' . $customer->cid;

                // cek duplikat tagihan berdasarkan bulan tertentu dan id pelanggan
                if (isset($itemsByCodes[$code])) {
                    continue;
                }

                $bill = new Bill();
                $bill->code = $code;
                $bill->date = $date;
                $bill->due_date = $due_date;
                $bill->customer_id = $customer->id;
                $bill->product_id = $customer->product_id;
                $bill->amount = $customer->product_price;

                $bill->company_id = current_user()->company_id;
                $billModel->save($bill);
            }
            $this->db->transCommit();

            return redirect()->to(base_url('bills'))->with('info', 'Tagihan telah dibuat');
        }

        return view('bill/generate', [
            'data' => $data,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getBillModel();

        if ($id) {
            if (!current_user_can(Acl::EDIT_BILL)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $data = $model->find($id);
            if (!$data || $data->company_id != current_user()->company_id) {
                return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
            }
        }
        else {
            if (!current_user_can(Acl::ADD_BILL)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            $data = new Bill();
            $data->date = date('Y-m-d');
            $data->due_date = date('Y-m-d');
        }

        if ($this->request->getMethod() == 'post') {
            $data->date = datetime_from_input($this->request->getPost('date'));
            $data->due_date = datetime_from_input($this->request->getPost('due_date'));
            $data->amount = $this->request->getPost('amount');
            $data->description = trim($this->request->getPost('description'));
            $data->notes = trim($this->request->getPost('notes'));

            try {
                $model->save($data);
            } catch (DataException $ex) {
            }

            return redirect()->to(base_url('bills/view/' . $data->id))->with('info', 'Tagihan telah diperbarui.');
        }
        
        return view('bill/edit', [
            'data' => $data,
            'products' => $this->getProductModel()->getAllActive(),
            'customers' => $this->getCustomerModel()->getAllActive()
        ]);
    }

    public function process()
    {
        $id = $this->request->getPost('id');
        $action = $this->request->getPost('action');        
        $model = $this->getBillModel();
        $bill = $model->find($id);
        if (!$bill || $bill->company_id != current_user()->company_id) {
            return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
        }

        if ($action == 'fully_paid') {
            if (!current_user_can(Acl::COMPLETE_BILL)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            $bill->status = 1;
        }
        else {
            if (!current_user_can(Acl::CANCEL_BILL)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            $bill->status = 2;
        }

        $bill->date_complete = date('Y-m-d H:i:s');
        $model->save($bill);
        return redirect()->to(base_url('bills'))->with('info', 'Tagihan ' . $bill->code . ' telah dibayar.');
    }

    public function delete($id)
    {
        if (!current_user_can(Acl::DELETE_BILL)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $model = $this->getBillModel();
        $bill = $model->find($id);
        if (!$bill || $bill->company_id != current_user()->company_id) {
            return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(base_url('bills'))->with('info', 'Tagihan telah dihapus.');
    }

    public function view($id)
    {
        if (!current_user_can(Acl::VIEW_BILL)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $model = $this->getBillModel();
        $bill = $model->find($id);
        if (!$bill || $bill->company_id != current_user()->company_id) {
            return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
        }
        $product = null;
        if ($bill->product_id) {
            $product = $this->getProductModel()->find($bill->product_id);
        }
        $customer = $this->getCustomerModel()->find($bill->customer_id);
        if (!$bill) {
            return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
        }

        $view = 'view';
        if ($this->request->getGet('print')) {
            $view = 'print';
        }

        return view("bill/$view", [
            'bill' => $bill,
            'data' => $customer,
            'product' => $product,
            'settings' => $this->getSettingModel()
        ]);
    }
}
