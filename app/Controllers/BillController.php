<?php

namespace App\Controllers;

use App\Entities\Bill;
use CodeIgniter\Database\Exceptions\DataException;
use stdClass;

class BillController extends BaseController
{
    public function index()
    {
        $filter = new stdClass;
        $filter->status = $this->request->getGet('status');
        $filter->daterange = (string)$this->request->getGet('daterange');
        
        if ($filter->status == null) {
            $filter->status = 0;
        }

        if (null == $filter->daterange) {
            $filter->dateStart = date('Y-m-01');
            $filter->dateEnd = date('Y-m-t');
        }
        
        if (strlen($filter->daterange) == 23) {
            $daterange = explode(' - ', $filter->daterange);
            $filter->dateStart = datetime_from_input($daterange[0]);
            $filter->dateEnd = datetime_from_input($daterange[1]);
        }

        $where = [];
        $where[] = 'b.company_id=' . current_user()->company_id;
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
            order by b.code asc";
        $items = $this->db->query($sql)->getResultObject();

        return view('bill/index', [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function generate()
    {
        $data = new stdClass;
        $data->date = date('Y-m-01');
        $data->due_date = date('Y-m-20');

        if ($this->request->getMethod() == 'post') {
            $billModel = $this->getBillModel();

            $data->date = datetime_from_input($this->request->getPost('date'));
            $data->due_date = datetime_from_input($this->request->getPost('due_date'));

            //TODO: VALIDASI

            // check duplikat tagihan
            $result = $this->db->query('
                select * from bills
                where date=:date: and company_id=' . current_user()->company_id, [
                'date' => $data->date
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
                
                $code = 'INV-' . current_user()->company_id . '-' . date('Ym', strtotime($data->date)) . '-' . $customer->cid;

                // cek duplikat tagihan berdasarkan bulan tertentu dan id pelanggan
                if (isset($itemsByCodes[$code])) {
                    continue;
                }

                $bill = new Bill();
                $bill->code = $code;
                $bill->date = $data->date;
                $bill->due_date = $data->due_date;
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
            $data = $model->find($id);
            if (!$data || $data->company_id != current_user()->company_id) {
                return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
            }
        }
        else {
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
            $bill->status = 1;
        }
        else {
            $bill->status = 2;
        }

        $bill->date_complete = date('Y-m-d H:i:s');
        $model->save($bill);
        return redirect()->to(base_url('bills'))->with('info', 'Tagihan ' . $bill->code . ' telah dibayar.');
    }

    public function delete($id)
    {
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
