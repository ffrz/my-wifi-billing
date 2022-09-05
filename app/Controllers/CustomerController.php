<?php

namespace App\Controllers;

use App\Entities\Customer;
use CodeIgniter\Database\Exceptions\DataException;

class CustomerController extends BaseController
{
    public function index()
    {
        $items = $this->getCustomerModel()->getAll();

        return view('customer/index', [
            'items' => $items,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getCustomerModel();
        if ($id == 0) {
            $item = new Customer();
            $item->status = 1;
        }
        else {
            $item = $model->find($id);
            if (!$item) {
                return redirect()->to(base_url('customers'))->with('warning', 'Pelanggan tidak ditemukan.');
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            if (!$id) {
                // username tidak boleh diganti
                $item->username = trim($this->request->getPost('username'));
            }

            $item->fill($this->request->getPost());

            if ($item->username == '') {
                $errors['username'] = 'ID Pelanggan harus diisi.';
            }
            else if ($model->exists($item->username, $item->id)) {
                $errors['username'] = 'ID Pelanggan sudah digunakan, harap gunakan ID yang lain.';
            }
            
            if ($item->fullname == '') {
                $errors['fullname'] = 'Nama lengkap harus diisi.';
            }
            else if ($item->fullname == '') {
                $errors['fullname'] = 'Nama lengkap harus diisi.';
            }
            
            if (!$item->id) {
                if ($item->password == '') {
                    $errors['password'] = 'Kata sandi harus diisi.';
                }
                else {
                    $item->password = sha1($item->password);
                }
            }
            else if ($item->password != '') {
                $item->password = sha1($item->password);
            }

            if (empty($errors)) {
                try {
                    $model->save($item);
                }
                catch (DataException $ex) {
                    if ($ex->getMessage() == 'There is no data to update. ') {
                        exit('fooo');
                        return;
                    }
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
        $model = $this->getCustomerModel(); 
        $item = $model->find($id);

        return view('customer/view', [
            'data' => $item,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getUserModel();
        $user = $model->find($id);

        if ($user->username == 'admin') {
            return redirect()->to(base_url('users'))
                ->with('error', 'Akun <b>' . esc($user->username) . '</b> tidak dapat dihapus.');
        }
        else if ($user->id == current_user()->id) {
            return redirect()->to(base_url('users'))
            ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($this->request->getMethod() == 'post') {
            $user->active = 0;
            $model->save($user);
            if ($model->delete($user->id)) {
                return redirect()->to(base_url('users'))->with('info', 'Pengguna ' . esc($user->username) . ' telah dihapus.');
            }

            return redirect()->to(base_url('users'))->with('info', 'Pengguna telah dinonaktifkan.');
        }

        return view('user/delete', [
            'data' => $user
        ]);
    }
}
