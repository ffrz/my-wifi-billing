<?php

namespace App\Controllers;

use App\Entities\Product;
use CodeIgniter\Database\Exceptions\DataException;
use Exception;
use stdClass;

class ProductController extends BaseController
{
    public function index()
    {
        $filter = new stdClass;
        $filter->active = $this->request->getGet('active');
        if ($filter->active == null) {
            $filter->active = 1;
        }

        $where = [];
        $where[] = 'p.company_id=' . current_user()->company_id;
        if ($filter->active != 'all') {
            $where[] = 'p.active=' . (int)$filter->active;
        }

        if (!empty($where)) {
            $where = ' where ' . implode(' and ', $where);
        } else {
            $where = '';
        }

        $items = $this->db->query("
            select p.*,
                (select ifnull(count(0), 0) from customers c where c.product_id=p.id) as customer_count
            from products p $where order by p.name asc
        ")->getResultObject();

        return view('product/index', [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getProductModel();
        $duplicate = $this->request->getGet('duplicate');

        if ($id == 0) {
            $item = new Product();
            $item->created_at = date('Y-m-d H:i:s');
            $item->created_by = current_user()->username;
            $item->company_id = current_user()->company_id;
            $item->active = 1;
            $item->bill_cycle = 1; // fixed, belum bisa selain 1 bulan
            $item->notify_before = 7; // belum dipakai
        } else {
            $item = $model->find($id);
            if (!$item || $item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('products'))->with('warning', 'Produk tidak ditemukan.');
            }

            if ($duplicate) {
                $item->id = 0;
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->fill($this->request->getPost());
            $item->active = (int)$this->request->getPost('active');
            $item->price = str_to_double($item->price);

            $item->name = trim($item->name);
            if (strlen($item->name) < 3) {
                $errors['name'] = 'Nama harus diisi, minimal 3 karakter.';
            } elseif (strlen($item->name) > 100) {
                $errors['name'] = 'Nama terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $item->name)) {
                $errors['name'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            } else if ($model->exists($item->name, $item->id)) {
                $errors['name'] = 'Nama sudah digunakan, silahkan gunakan nama lain.';
            }

            if (empty($errors)) {
                $item->updated_at = date('Y-m-d H:i:s');
                $item->updated_by = current_user()->username;
                $model->save($item);
                return redirect()->to(base_url("products"))->with('info', 'Data Produk telah disimpan.');
            }
        }

        return view('product/edit', [
            'data' => $item,
            'duplicate' => $duplicate,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getProductModel();
        $product = $model->find($id);

        if (!$product || $product->company_id != current_user()->company_id) {
            return redirect()->to(base_url('products'))->with('warning', 'Produk tidak ditemukan.');
        }

        $product->active = false;
        $product->deleted_at = date('Y-m-d H:i:s');
        $product->deleted_by = current_user()->username;

        try {
            $model->save($product);
        } catch (Exception $ex) {
        }

        return redirect()->to(base_url('products'))->with('info', 'Produk telah dinonaktifkan.');
    }
}
