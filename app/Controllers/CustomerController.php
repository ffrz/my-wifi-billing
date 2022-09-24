<?php

namespace App\Controllers;

use App\Entities\Acl;
use App\Entities\Customer;
use App\Entities\ProductActivation;
use CodeIgniter\Database\Exceptions\DataException;
use stdClass;

class CustomerController extends BaseController
{
    public function index()
    {
        if (!current_user_can(Acl::VIEW_CUSTOMERS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $session = session();
        $filter = $session->get('customer_filter');

        if (!$filter) {
            $filter = new stdClass;
        }

        if (!isset($filter->status)) {
            $filter->status = 1;
        }

        if (($status = $this->request->getGet('status')) != null) {
            $filter->status = $status;
        }
        
        $session->set('customer_filter', $filter);

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
            if (!current_user_can(Acl::ADD_CUSTOMER)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $item = new Customer();
            $item->status = 1;
            $item->installation_date = date('Y-m-d');
            $item->created_at = date('Y-m-d H:i:s');
            $item->created_by = current_user()->username;
            $item->company_id = current_user()->company_id;

            $next_id = $this->db->query('
                select ifnull(max(cid), 0)+1 id
                from customers
                where company_id=' . current_user()->company_id . ' limit 1')
                ->getRow()->id;
            $item->cid = $next_id;
        } else {
            if (!current_user_can(Acl::EDIT_CUSTOMER)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $item = $model->find($id);
            if (!$item || $item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('customers'))->with('warning', 'Pelanggan tidak ditemukan.');
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->fill($this->request->getPost());
            $item->installation_date = datetime_from_input($item->installation_date);

            $item->fullname = trim($item->fullname);
            if (strlen($item->fullname) < 3) {
                $errors['fullname'] = 'Nama harus diisi, minimal 3 karakter.';
            } elseif (strlen($item->fullname) > 100) {
                $errors['fullname'] = 'Nama terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $item->fullname)) {
                $errors['fullname'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }
            // else if ($model->exists($item->fullname, $item->id)) {
            //     $errors['fullname'] = 'Nama sudah digunakan, silahkan gunakan nama lain.';
            // }

            if (empty($errors)) {
                $item->updated_at = date('Y-m-d H:i:s');
                $item->updated_by = current_user()->username;
                $model->save($item);
                $id = $item->id ? $item->id : $this->db->insertID();
                return redirect()->to(base_url("customers/view/{$id}"))->with('info', 'Data Pelanggan telah disimpan.');
            }
        }

        return view('customer/edit', [
            'data' => $item,
            'errors' => $errors,
        ]);
    }

    public function view($id)
    {
        if (!current_user_can(Acl::VIEW_CUSTOMER)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

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

        $item->bills = $this->db->query("
            select b.*, p.name product_name
            from bills b
            inner join products p on p.id = b.product_id
            where b.customer_id=$id
            order by id desc
        ")->getResultObject();

        return view('customer/view', [
            'data' => $item,
        ]);
    }

    public function delete($id)
    {
        if (!current_user_can(Acl::DELETE_CUSTOMER)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

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
        if (!current_user_can(Acl::CHANGE_CUSTOMER_PRODUCT)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

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
                $errors['product_id'] = 'Silahkan pilih layanan.';
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
