<?php

namespace App\Controllers;

use stdClass;

class AuthController extends BaseController
{
    public function login()
    {
        $session = session();
        $username = '';
        $password = '';
        $remember = 1;
        $error = null;

        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $remember = (bool)$this->request->getPost('remember');
            $user = $this->getUserModel()->findByUsername($username);

            if ($username == '') {
                $error = 'Username harus diisi.';
            }
            else if (empty($password)) {
                $error = 'Masukkan kata sandi anda.';
            }
            else if (!$user) {
                $error = 'Pengguna tidak ditemukan.';
            }
            else if (!$user->active) {
                $error = 'Akun anda tidak aktif.';
            }
            else if ($user->password != sha1($password)) {
                $error = 'Kata sandi anda salah.';
            }
            else {
                
                $currentUser = new stdClass;
                $currentUser->id = $user->id;
                $currentUser->username = $username;
                $currentUser->is_admin = $user->is_admin;
                $currentUser->group_id = $user->group_id;
                $currentUser->company_id = $user->company_id;
                $currentUser->acl = [];
                
                $acl = [];
                if ($user->group_id) {
                    $acl = $this->db->query("
                        select * from user_group_acl where group_id=$user->group_id")->getResultObject();
                    foreach ($acl as $d) {
                        $currentUser->acl[$d->resource] = $d->allowed;
                    }
                }
                $session->set('current_user', $currentUser);
                return redirect()->to(base_url('/'));
            }
        }

        $password = '';
        return view('auth/login', [
            'username' => $username,
            'password' => $password,
            'remember' => $remember,
            'error' => $error,
        ]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }
}
