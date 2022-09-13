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
        if ($filter->status == null) {
            $filter->status = 1;
        }

        $where = '';

        $sql = "select
            b.*, c.fullname, c.wa, c.address, c.username
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
            $result = $this->db->query('select * from bills where date=:date:', [
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
                
                $code = 'INV-' . date('Ymd', strtotime($data->date)) . '-' . $customer->username;

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
        $data = new Bill();
        $data->date = date('Y-m-d');
        $data->due_date = date('Y-m-d');
        
        return view('bill/edit', [
            'data' => $data,
            'customers' => $this->getCustomerModel()->getAllActive()
        ]);
    }

    public function delete($id)
    {
        $model = $this->getBillModel();
        $bill = $model->find($id);
        if (!$bill) {
            return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
        }

        $model->delete($id);

        return redirect()->to(base_url('bills'))->with('info', 'Tagihan telah dihapus.');
    }

    public function view($id)
    {
        $model = $this->getBillModel();
        $bill = $model->find($id);
        $customer = $this->getCustomerModel()->find($bill->customer_id);
        if (!$bill) {
            return redirect()->to(base_url('bills'))->with('warning', 'Tagihan tidak ditemukan.');
        }

        return view('bill/view', [
            'bill' => $bill,
            'data' => $customer
        ]);
    }
}
