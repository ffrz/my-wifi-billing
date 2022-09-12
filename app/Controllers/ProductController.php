<?php

namespace App\Controllers;

use App\Entities\Product;
use CodeIgniter\Database\Exceptions\DataException;
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
        if ($filter->active != 'all') {
            $where[] = 'active=' . (int)$filter->active;
        }

        if (!empty($where)) {
            $where = ' where ' . implode(' and ', $where);
        } else {
            $where = '';
        }

        $items = $this->db->query("
            select * from products $where order by name asc
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
            $item->active = 1;
            $item->bill_cycle = 1; // fixed, belum bisa selain 1 bulan
            $item->notify_before = 7; // belum dipakai
        } else {
            $item = $model->find($id);
            if (!$item) {
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

            if ($item->name == '') {
                $errors['name'] = 'Nama Produk harus diisi.';
            } else if ($model->exists($item->name, $item->id)) {
                $errors['name'] = 'Nama Produk sudah digunakan, harap gunakan nama yang lain.';
            }

            if (empty($errors)) {
                try {
                    $item->updated_at = date('Y-m-d H:i:s');
                    $item->updated_by = current_user()->username;
                    $model->save($item);
                } catch (DataException $ex) {
                    if ($ex->getMessage() == 'There is no data to update. ') {
                    }
                }

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

        $product->active = false;
        $product->deleted_at = date('Y-m-d H:i:s');
        $product->deleted_by = current_user()->username;

        try {
            $model->save($product);
        } catch (DataException $ex) {
        }

        return redirect()->to(base_url('products'))->with('info', 'Produk telah dinonaktifkan.');
    }
}
