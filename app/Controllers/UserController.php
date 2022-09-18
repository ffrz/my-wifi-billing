<?php

namespace App\Controllers;

use App\Entities\Acl;
use App\Entities\User;
use CodeIgniter\Database\Exceptions\DataException;

class UserController extends BaseController
{
    public function index()
    {
        if (!current_user_can(Acl::VIEW_USERS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

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
            if (!current_user_can(Acl::ADD_USER)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $count = $this->db->query('select count(0) as count from users where company_id=' . current_user()->company_id)
                ->getRowObject()->count;
            if ($count >= MAX_USER) {
                return redirect()->to(base_url('users'))->with('error', 'Anda telah mencapai batas maksimum pembuatan akun pengguna.');
            }

            $data = new User();
            $data->active = true;
            $data->is_admin = false;
        } else {
            if (!current_user_can(Acl::EDIT_USER)) {
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $data = $model->find($id);
            if (!$data || $data->company_id != current_user()->company_id) {
                return redirect()->to(base_url('users'))->with('warning', 'Pengguna tidak ditemukan.');
            }

            $oldPassword = $data->password;
        }

        // ga boleh edit akun sendiri
        if ($data->username == current_user()->username) {
            return redirect()->to(base_url('users'))->with('error', 'Akun ini tidak dapat diubah.');
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            if (!$id) {
                // username tidak boleh diganti
                $data->username = trim($this->request->getPost('username'));
            }

            $data->fullname = trim($this->request->getPost('fullname'));
            $data->password = $this->request->getPost('password');
            // $item->is_admin = (int)$this->request->getPost('is_admin');
            $data->active = (int)$this->request->getPost('active');
            $data->group_id = (int)$this->request->getPost('group_id');

            if ($data->group_id == 0) {
                $data->group_id = null;
            }

            if (strlen($data->username) < 3 || strlen($data->username) > 40) {
                $errors['username'] = 'Username harus diisi. minimal 3 karakter, maksimal 40 karakter.';
            }
            else if (!preg_match('/^[a-zA-Z\d_]+$/i', $data->username)) {
                $errors['username'] = 'Username tidak valid, gunakan huruf alfabet, angka dan underscore.';
            }
            else if ($model->exists($data->username, $data->id)) {
                $errors['username'] = 'Username sudah digunakan, harap gunakan nama lain.';
            }
            
            if (strlen($data->fullname) < 3 || strlen($data->fullname) > 100) {
                $errors['fullname'] = 'Nama harus diisi. Minimal 3 karakter, maksimal 100 karakter.';
            }
            else if (!preg_match('/^[a-zA-Z\d ]+$/i', $data->fullname)) {
                $errors['fullname'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }
            
            $change_password = false;
            if (!$data->id || $data->password != '') {
                $change_password = true;
                if (strlen($data->password) < 3 || strlen($data->password) > 40) {
                    $errors['password'] = 'Kata sandi harus diisi. minimal 3 karakter, maksimal 40 karakter.';
                }
            }

            if (empty($errors)) {
                if ($change_password) {
                    $data->password = sha1($data->password);
                }
                else {
                    $data->password = $oldPassword;
                }

                if (!$data->id) {
                    $data->company_id = current_user()->company_id;
                    $data->created_by = current_user()->username;
                    $data->created_at = current_datetime();
                }

                $data->updated_at = current_datetime();
                $data->updated_by = current_user()->username;

                try {
                    $model->save($data);
                } catch (DataException $ex) {

                }

                return redirect()->to(base_url('users'))->with('info', 'Akun pengguna telah disimpan.');
            }
        } else {
            $data->password = '';
        }

        return view('user/edit', [
            'data' => $data,
            'userGroups' => $this->getUserGroupModel()->getAll(),
            'errors' => $errors,
        ]);
    }

    public function profile()
    {
        $model = $this->getUserModel();
        $data = $model->find(current_user()->id);
        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $data->fullname = trim($this->request->getPost('fullname'));
            $data->password1 = $this->request->getPost('password1');
            $data->password2 = $this->request->getPost('password2');
            $input_current_password = $this->request->getPost('current_password');
            $change_password = false;

            if ($data->fullname == '') {
                $errors['fullname'] = 'Nama harus diisi.';
            } elseif (strlen($data->fullname) > 100) {
                $errors['fullname'] = 'Nama terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $data->fullname)) {
                $errors['fullname'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }

            if ($input_current_password == '') {
                $errors['current_password'] = 'Anda harus mengisi kata sandi.';
            } else if (sha1($input_current_password) != $data->password) {
                $errors['current_password'] = 'Kata sandi salah.';
            }

            if ($data->password1 != '') {
                $change_password = true;
                // user ingin mengganti password
                if (strlen($data->password1) < 3) {
                    $errors['password1'] = 'Kata sandi anda terlalu pendek, minimal 3 karakter.';
                }
                else if (strlen($data->password1) > 40) {
                    $errors['password1'] = 'Kata sandi anda terlalu panjang, maksimal 40 karakter.';
                }
                else if ($data->password1 != $data->password2) {
                    $errors['password2'] = 'Kata sandi yang anda konfirmasi tidak cocok.';
                }
            }

            if (empty($errors)) {
                if ($change_password) {
                    $data->password = sha1($data->password1);
                }

                $data->updated_at = current_datetime();
                $data->updated_by = current_user()->username;
                
                try {
                    $model->save($data);
                } catch (DataException $ex) {
                }

                return redirect()->to(base_url('users/profile'))->with('info', 'Profil telah diperbarui.');
            }
        } else {
            $data->password1 = '';
            $data->password2 = '';
        }

        if ($data->group_id) {
            $data->group_name = $this->getUserGroupModel()->find($data->group_id)->name;
        }
        return view('user/profile', [
            'data' => $data,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        if (!current_user_can(Acl::DELETE_USER)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $model = $this->getUserModel();
        $user = $model->find($id);

        if (!$user || $user->company_id != current_user()->company_id) {
            return redirect()->to(base_url('users'))->with('warning', 'Rekaman tidak ditemukan.');
        }

        if ($user->is_admin) {
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
