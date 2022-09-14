<?php

namespace App\Controllers;

use App\Entities\Customer;
use App\Entities\ProductActivation;
use CodeIgniter\Database\Exceptions\DataException;
use stdClass;

class CustomerController extends BaseController
{
    public function index()
    {
        $filter = new stdClass;
        $filter->status = $this->request->getGet('status');
        if ($filter->status == null) {
            $filter->status = 1;
        }

        $items = $this->getCustomerModel()->getAllWithFilter($filter);

        return view('customer/index', [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getCustomerModel();
        if ($id == 0) {
            $item = new Customer();
            $item->status = 1;
            $item->installation_date = date('Y-m-d');

            $next_id = $this->db->query('
                select ifnull(max(cid), 0)+1 id
                from customers
                where company_id=' . current_user()->company_id . ' limit 1')
                ->getRow()->id;
            $item->cid = $next_id;
        } else {
            $item = $model->find($id);
            if (!$item || $item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('customers'))->with('warning', 'Pelanggan tidak ditemukan.');
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->fill($this->request->getPost());

            if ($item->fullname == '') {
                $errors['fullname'] = 'Nama lengkap harus diisi.';
            } else if ($item->fullname == '') {
                $errors['fullname'] = 'Nama lengkap harus diisi.';
            }

            if (empty($errors)) {
                try {
                    if ($item->id) {
                        $item->updated_at = date('Y-m-d H:i:s');
                        $item->updated_by = current_user()->username;
                    } else {
                        $item->created_at = date('Y-m-d H:i:s');
                        $item->created_by = current_user()->username;
                    }

                    if (!$item->company_id) {
                        $item->company_id = current_user()->company_id;
                    }
                    $model->save($item);
                } catch (DataException $ex) {
                }
                $id = $item->id ? $item->id : $this->db->insertID();
                return redirect()->to(base_url("customers/view/{$id}"))->with('info', 'Data Pelanggan telah disimpan.');
            }
        }

        $item->password = '';
        return view('customer/edit', [
            'data' => $item,
            'errors' => $errors,
        ]);
    }

    public function view($id)
    {
        $item = $this->db->query("
        select c.*, p.name product_name
        from customers c
        left join products p on p.id = c.product_id
        where c.id=$id
        ")->getRow();

        if (!$item || $item->company_id != current_user()->company_id) {
            return redirect()->to(base_url('customers'))->with('warning', 'Pelanggan tidak ditemukan.');
        }

        $item->productActivations = $this->db->query("
            select a.*, p.name product_name from product_activations a
            inner join products p on p.id = a.product_id
            where a.customer_id=$id
            order by a.id desc
        ")->getResultObject();

        return view('customer/view', [
            'data' => $item,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getCustomerModel();
        $item = $model->find($id);
        if (!$item || $item->company_id != current_user()->company_id) {
            return redirect()->to(base_url('customers'))->with('warning', 'Pelanggan tidak ditemukan.');
        }

        $item->status = 0;
        $item->deleted_at = date('Y-m-d H:i:s');
        $item->deleted_by = current_user()->username;

        try {
            $model->save($item);
        } catch (DataException $ex) {
        }

        return redirect()->to(base_url('customers'))->with('info', 'Pelanggan telah dinonaktifkan.');
    }

    public function activateProduct($id)
    {
        $customerModel = $this->getCustomerModel();
        $customer = $customerModel->find($id);
        if (!$customer || $customer->company_id != current_user()->company_id) {
            return redirect()->to(base_url('customers'))->with('warning', 'Pelanggan tidak ditemukan.');
        }

        $item = new ProductActivation();
        $item->date = date('Y-m-d');
        $item->product_id = 0;
        $item->price = 0;

        $current_product = null;
        if ($customer->product_id) {
            $current_product = $this->getProductModel()->find($customer->product_id);
        }

        $errors = [];

        if ($this->request->getMethod() == 'post') {
            $item->date = datetime_from_input($this->request->getPost('date'));
            $item->product_id = (int)$this->request->getPost('product_id');
            $item->price = $this->request->getPost('price');
            $item->customer_id = $this->request->getPost('id');
            $item->bill_period = 1;

            if (!$item->product_id) {
                $errors['product_id'] = 'Silahkan pilih produk.';
            }

            if (empty($errors)) {
                $this->db->transBegin();

                $this->getProductActivationModel()->save($item);

                try {
                    $customer->product_id = $item->product_id;
                    $customer->product_price = $item->price;
                    $customerModel->save($customer);
                } catch (DataException $ex) {
                }

                $this->db->transCommit();

                return redirect()->to(base_url('customers'))->with('info', 'Paket telah ditambahkan ke pelanggan.');
            }
        }

        return view('customer/activate-product', [
            'data' => $item,
            'errors' => $errors,
            'current_product' => $current_product,
            'customer' => $customer,
            'products' => $this->getProductModel()->getAllActive()
        ]);
    }
}
