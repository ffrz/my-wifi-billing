<?php

namespace App\Controllers;

use App\Entities\Acl;
use App\Entities\UserGroup;
use CodeIgniter\Database\Exceptions\DataException;

class UserGroupController extends BaseController
{
    public function index()
    {
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
            $item = new UserGroup();
        }
        else {
            $item = $model->find($id);
            if (!$item) {
                return redirect()->to(base_url('user-groups'))->with('warning', 'Rekaman tidak ditemukan');
            }
            if ($item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('user-groups'))->with('warning', 'Rekaman tidak ditemukan');
            }

            $acl = $this->db->query("
                select resource, allowed
                from user_group_acl
                where group_id=$id"
            )->getResultObject();
            foreach ($acl as $a) {
                $acl_by_resouces[$a->resource] = $a->allowed;
            }
        }
        $item->acl = $acl_by_resouces;

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->name = trim($this->request->getPost('name'));
            $item->description = trim($this->request->getPost('description'));
            $item->acl = (array)$this->request->getPost('acl');

            if ($item->name == '') {
                $errors['name'] = 'Nama harus diisi.';
            }
            else if ($model->exists($item->name, $item->id)) {
                $errors['name'] = 'Nama sudah digunakan, harap gunakan nama lain.';
            }

            if (empty($errors)) {                
                $this->db->transBegin();
                
                try {
                    if (!$item->company_id) {
                        $item->company_id = current_user()->company_id;
                    }
                    $model->save($item);
                }
                catch (DataException $ex) {
                }

                if (!$item->id) {
                    $item->id = $this->db->insertID();
                }

                $this->db->query('delete from user_group_acl where group_id=' . $item->id);
                foreach ($item->acl as $k => $v) {
                    if (!in_array($k, Acl::getResources())) {
                        continue;
                    }
                    $this->db->query("insert into
                        user_group_acl (group_id, resource, allowed)
                        values ($item->id,'$k',1)");
                }

                $this->db->transCommit();
                return redirect()->to(base_url('user-groups'))->with('info', 'Grup pengguna telah disimpan.');
            }
        }
        
        return view('user-group/edit', [
            'data' => $item,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getUserGroupModel();
        $userGroup = $model->find($id);
        if (!$userGroup) {
            return redirect()->to(base_url('user-groups'))->with('warning', 'Rekaman tidak ditemukan');
        }

        if ($userGroup->company_id != current_user()->company_id) {
            return redirect()->to(base_url('user-groups'))->with('warning', 'Rekaman tidak ditemukan');
        }

        // TODO: cek jumlah pengguna, jika ada tidak boleh dihapus

        $message = 'Grup pengguna tidak dapat dihapus.';

        if ($model->delete($userGroup->id)) {
            $message = 'Grup pengguna telah dihapus.';
        }

        return redirect()->to(base_url('user-groups'))->with('info', $message);
    }
}
