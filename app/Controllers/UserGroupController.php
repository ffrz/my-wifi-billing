<?php

namespace App\Controllers;

use App\Entities\Acl;
use App\Entities\UserGroup;
use CodeIgniter\Database\Exceptions\DataException;
use Exception;

class UserGroupController extends BaseController
{
    public function index()
    {
        if (!current_user_can(Acl::VIEW_USER_GROUPS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $items = $this->getUserGroupModel()->getAll();

        return view('user-group/index', [
            'items' => $items,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getUserGroupModel();
        $acl_by_resouces = Acl::createResources();

        if ($id == 0) {
            if (!current_user_can(Acl::ADD_USER_GROUP)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $count = $this->db->query('select count(0) as count from user_groups where company_id=' . current_user()->company_id)
                ->getRowObject()->count;
            if ($count >= MAX_USER_GROUP) {
                return redirect()->to(base_url('user-groups'))->with('error', 'Anda telah mencapai batas maksimum pembuatan grup pengguna.');
            }
            $data = new UserGroup();
        } else {
            if (!current_user_can(Acl::EDIT_USER_GROUP)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $data = $model->find($id);
            if (!$data || $data->company_id != current_user()->company_id) {
                return redirect()->to(base_url('user-groups'))->with('warning', 'Rekaman tidak ditemukan');
            }

            $acl = $this->db->query(
                "select resource, allowed
                from user_group_acl
                where group_id=$id"
            )->getResultObject();
            foreach ($acl as $a) {
                $acl_by_resouces[$a->resource] = $a->allowed;
            }
        }

        $data->acl = $acl_by_resouces;
        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $data->name = trim($this->request->getPost('name'));
            $data->description = trim($this->request->getPost('description'));
            $data->acl = (array)$this->request->getPost('acl');

            if (strlen($data->name) < 3 || strlen($data->name) > 100) {
                $errors['name'] = 'Nama grup  harus diisi. Minimal 3 karakter, maksimal 100 karakter.';
            }
            else if (!preg_match('/^[a-zA-Z\d ]+$/i', $data->name)) {
                $errors['name'] = 'Nama grup tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }
            else if ($model->exists($data->name, $data->id)) {
                $errors['name'] = 'Nama grup sudah digunakan, harap gunakan nama lain.';
            }

            if (empty($errors)) {
                $this->db->transBegin();

                try {
                    if (!$data->id) {
                        $data->company_id = current_user()->company_id;
                    }
                    $model->save($data);
                } catch (DataException $ex) {
                }

                if (!$data->id) {
                    $data->id = $this->db->insertID();
                }

                $this->db->query('delete from user_group_acl where group_id=' . $data->id);
                foreach ($data->acl as $k => $v) {
                    if (!in_array($k, Acl::getResources())) {
                        continue;
                    }
                    $this->db->query("insert into
                        user_group_acl (group_id, resource, allowed)
                        values ($data->id,'$k',1)");
                }

                $this->db->transCommit();
                return redirect()->to(base_url('user-groups/edit/' . $data->id))->with('info', 'Grup pengguna telah disimpan.');
            }
        }

        return view('user-group/edit', [
            'data' => $data,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        if (!current_user_can(Acl::DELETE_USER_GROUP)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = $this->getUserGroupModel();
        $data = $model->find($id);
        if (!$data || $data->company_id != current_user()->company_id) {
            return redirect()->to(base_url('user-groups'))->with('warning', 'Rekaman tidak ditemukan');
        }

        try {
            $model->delete($data->id);
            $message = 'Grup pengguna telah dihapus.';
        } catch (Exception $ex) {
            $message = 'Grup pengguna tidak dapat dihapus.';
        }

        return redirect()->to(base_url('user-groups'))->with('info', $message);
    }
}
