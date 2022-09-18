<?php

namespace App\Controllers;

use App\Entities\User;
use CodeIgniter\Database\Exceptions\DataException;

class UserController extends BaseController
{
    public function index()
    {
        $items = $this->getUserModel()->getAll();

        return view('user/index', [
            'items' => $items,
        ]);
    }

    public function edit($id)
    {
        $oldPassword = '';
        $model = $this->getUserModel();
        if ($id == 0) {
            $item = new User();
        } else {
            $item = $model->find($id);
            if (!$item || $item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('users'))->with('warning', 'Pengguna tidak ditemukan.');
            }

            $oldPassword = $item->password;
        }

        // ga boleh edit akun sendiri
        if ($item->username == current_user()->username) {
            return redirect()->to(base_url('users'))->with('error', 'Akun ini tidak dapat diubah.');
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            if (!$id) {
                // username tidak boleh diganti
                $item->username = trim($this->request->getPost('username'));
            }

            $item->fullname = trim($this->request->getPost('fullname'));
            $item->password = $this->request->getPost('password');
            $item->is_admin = (int)$this->request->getPost('is_admin');
            $item->active = (int)$this->request->getPost('active');
            $item->group_id = (int)$this->request->getPost('group_id');

            if ($item->group_id == 0) {
                $item->group_id = null;
            }

            if ($item->username == '') {
                $errors['username'] = 'Username harus diisi.';
            } else if ($model->exists($item->username, $item->id)) {
                $errors['username'] = 'Username sudah digunakan, harap gunakan nama lain.';
            } else if ($item->fullname == '') {
                $errors['fullname'] = 'Nama lengkap harus diisi.';
            } else if (!$item->id) {
                if ($item->password == '') {
                    $errors['password'] = 'Kata sandi harus diisi.';
                } else {
                    $item->password = sha1($item->password);
                }
            } else if ($item->password != '') {
                $item->password = sha1($item->password);
            }

            if (empty($errors)) {

                if ($item->password === '' && $oldPassword !== '') {
                    // user ga mengganti password maka reset dengan password lama
                    $item->password = $oldPassword;
                }

                try {
                    if (!$item->company_id) {
                        $item->company_id = current_user()->company_id;
                    }
                    $model->save($item);
                } catch (DataException $ex) {
                    if ($ex->getMessage() == 'There is no data to update. ') {
                    }
                }
                return redirect()->to(base_url('users'))->with('info', 'Berhasil disimpan.');
            }
        } else {
            $item->password = '';
        }

        return view('user/edit', [
            'data' => $item,
            'userGroups' => $this->getUserGroupModel()->getAll(),
            'errors' => $errors,
        ]);
    }

    public function profile()
    {
        $id = current_user()->id;
        $errors = [];

        $model = $this->getUserModel();
        $item = $model->find($id);

        if ($this->request->getMethod() === 'post') {
            $item->fullname = trim($this->request->getPost('fullname'));
            $item->password1 = $this->request->getPost('password1');
            $item->password2 = $this->request->getPost('password2');
            $input_current_password = $this->request->getPost('current_password');
            $change_password = false;

            if ($item->fullname == '') {
                $errors['fullname'] = 'Nama harus diisi.';
            } elseif (strlen($item->fullname) > 100) {
                $errors['fullname'] = 'Nama terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $item->fullname)) {
                $errors['fullname'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }

            if ($input_current_password == '') {
                $errors['current_password'] = 'Anda harus mengisi kata sandi.';
            } else if (sha1($input_current_password) != $item->password) {
                $errors['current_password'] = 'Kata sandi salah.';
            }

            if ($item->password1 != '') {
                $change_password = true;
                // user ingin mengganti password
                if (strlen($item->password1) < 3) {
                    $errors['password1'] = 'Kata sandi anda terlalu pendek, minimal 3 karakter.';
                }
                else if (strlen($item->password1) > 40) {
                    $errors['password1'] = 'Kata sandi anda terlalu panjang, maksimal 40 karakter.';
                }
                else if ($item->password1 != $item->password2) {
                    $errors['password2'] = 'Kata sandi yang anda konfirmasi tidak cocok.';
                }
            }

            if (empty($errors)) {
                if ($change_password) {
                    $item->password = sha1($item->password1);
                }
                
                try {
                    $model->save($item);
                } catch (DataException $ex) {
                    if ($ex->getMessage() == 'There is no data to update. ') {
                    }
                }
                return redirect()->to(base_url('users/profile'))->with('info', 'Berhasil disimpan.');
            }
        } else {
            $item->password1 = '';
            $item->password2 = '';
        }

        return view('user/profile', [
            'data' => $item,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getUserModel();
        $user = $model->find($id);

        if (!$user || $user->company_id != current_user()->company_id) {
            return redirect()->to(base_url('users'))->with('warning', 'Rekaman tidak ditemukan.');
        }

        if ($user->username == 'admin') {
            return redirect()->to(base_url('users'))
                ->with('error', 'Akun <b>' . esc($user->username) . '</b> tidak dapat dihapus.');
        } else if ($user->id == current_user()->id) {
            return redirect()->to(base_url('users'))
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($this->request->getMethod() == 'post') {
            $user->active = 0;
            try {
                $model->save($user);
            } catch (DataException $ex) {
                if ($ex->getMessage() == 'There is no data to update. ') {
                }
            }
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
