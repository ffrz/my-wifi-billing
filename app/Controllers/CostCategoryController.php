<?php

namespace App\Controllers;

use App\Entities\Acl;
use App\Entities\CostCategory;
use CodeIgniter\Database\Exceptions\DataException;

class CostCategoryController extends BaseController
{
    public function index()
    {
        if (!current_user_can(Acl::VIEW_COST_CATEGORIES)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $items = $this->getCostCategoryModel()->getAll();

        return view('cost-category/index', [
            'items' => $items,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getCostCategoryModel();
        if ($id == 0) {
            if (!current_user_can(Acl::ADD_COST_CATEGORY)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $count = $this->db->query('select count(0) as count from cost_categories where company_id=' . current_user()->company_id)
                ->getRowObject()->count;
            if ($count >= MAX_COST_CATEGORY) {
                return redirect()->to(base_url('cost-categories'))->with('error', 'Anda telah mencapai batas maksimum pembuatan kategori biaya oprasional.');
            }
            $item = new CostCategory();
        } else {
            if (!current_user_can(Acl::EDIT_COST_CATEGORY)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $item = $model->find($id);
            if (!$item || $item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('cost-categories'))->with('warning', 'Kategori tidak ditemukan.');
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->fill($this->request->getPost());

            $item->name = trim($item->name);
            if (strlen($item->name) < 3) {
                $errors['name'] = 'Nama Kategori harus diisi, minimal 3 karakter.';
            } elseif (strlen($item->name) > 100) {
                $errors['name'] = 'Nama Kategori terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $item->name)) {
                $errors['name'] = 'Nama Kategori tidak valid, gunakan huruf alfabet, angka dan spasi.';
            } else if ($model->exists($item->name, $item->id)) {
                $errors['name'] = 'Nama Kategori sudah digunakan, silahkan gunakan nama lain.';
            }
            
            if (empty($errors)) {
                try {
                    if (!$item->id) {
                        $item->company_id = current_user()->company_id;
                    }
                    $model->save($item);
                } catch (DataException $ex) {
                }
                return redirect()->to(base_url("cost-categories"))->with('info', 'Kategori telah disimpan.');
            }
        }

        return view('cost-category/edit', [
            'data' => $item,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        if (!current_user_can(Acl::DELETE_COST_CATEGORY)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = $this->getCostCategoryModel();
        $item = $model->find($id);
        if (!$item || $item->company_id != current_user()->company_id) {
            return redirect()->to(base_url('cost-categories'))->with('warning', 'Kategori tidak ditemukan.');
        }

        $this->db->query("delete from cost_categories where id=$item->id");
        
        return redirect()->to(base_url('cost-categories'))->with('info', 'Kategori telah dihapus.');
    }
}
