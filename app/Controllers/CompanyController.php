<?php

namespace App\Controllers;

use App\Entities\Company;
use App\Entities\User;
use App\Models\CompanyModel;
use CodeIgniter\Database\Exceptions\DataException;
use stdClass;

class CompanyController extends BaseController
{
    public function index()
    {
        $items = $this->getCompanyModel()->getAll();

        return view('company/index', [
            'items' => $items,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getCompanyModel();
        if ($id == 0) {
            $item = new Company();
        } else {
            $item = $model->find($id);
            if (!$item) {
                return redirect()->to(base_url('companies'))->with('warning', 'Perusahaan tidak ditemukan.');
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->fill($this->request->getPost());

            if ($item->name == '') {
                $errors['name'] = 'Nama Perusahaan harus diisi.';
            } else if ($item->name == '') {
                $errors['name'] = 'Nama lengkap harus diisi.';
            }

            if (empty($errors)) {
                try {
                    $model->save($item);
                } catch (DataException $ex) {
                }
                return redirect()->to(base_url("companies"))->with('info', 'Data Perusahaan telah disimpan.');
            }
        }

        return view('company/edit', [
            'data' => $item,
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getCompanyModel();
        $item = $model->find($id);
        if (!$item) {
            return redirect()->to(base_url('companies'))->with('warning', 'Perusahaan tidak ditemukan.');
        }

        try {
            $model->save($item);
        } catch (DataException $ex) {
        }

        return redirect()->to(base_url('companies'))->with('info', 'Perusahaan telah dihapus.');
    }

    public function register()
    {
        $data = new Company();
        $errors = [];

        if ($this->request->getMethod() == 'post') {
            $data->name = trim((string)$this->request->getPost('name'));
            $data->owner_name = trim((string)$this->request->getPost('owner_name'));
            $data->phone = trim((string)$this->request->getPost('phone'));
            $data->address = trim((string)$this->request->getPost('address'));

            if (strlen($data->name) < 2) {
                $errors['name'] = 'Nama harus diisi, setidaknya 2 karakter.';
            } elseif (strlen($data->name) > 100) {
                $errors['name'] = 'Nama terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $data->name)) {
                $errors['name'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }

            if (strlen($data->owner_name) < 2) {
                $errors['owner_name'] = 'Nama harus diisi, setidaknya 2 karakter.';
            } elseif (strlen($data->owner_name) > 100) {
                $errors['owner_name'] = 'Nama terlalu panjang, maksimal 100 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d ]+$/i', $data->owner_name)) {
                $errors['owner_name'] = 'Nama tidak valid, gunakan huruf alfabet, angka dan spasi.';
            }

            if (strlen($data->phone) < 2 || strlen($data->phone) > 13) {
                $errors['phone'] = 'Nomor telepon harus diisi.';
            } else if (!preg_match('/^0[\d]+$/i', $data->phone)) {
                $errors['phone'] = 'Nomor telepon tidak valid.';
            }

            if (strlen($data->address) < 10) {
                $errors['address'] = 'Alamat harus diisi.';
            }

            if (empty($errors)) {
                // harus divalidasi agar tidak terjadi duplikat
                $model = $this->getCompanyModel();
                $data->activation_code = sha1($data->phone . '-wifiku-' . time());
                $model->save($data);
                $id = $this->db->insertID();
                return redirect()->to(base_url('register/success?cid='.$id.'&phone='.$data->phone));
            }
        }

        return view('company/register', [
            'data' => $data,
            'errors' => $errors
        ]);
    }

    public function registerSuccess()
    {
        $cid = (int)$this->request->getGet('cid');
        $data = $this->getCompanyModel()->find($cid);
        if (!$data || $data->active) {
            return redirect()->to(base_url('login'));
        }

        return view('company/register-success', [
            'data' => $data
        ]);
    }

    public function activate()
    {
        $data = new stdClass;
        $data->cid = (int)$this->request->getGetPost('cid');
        $data->code = (string)$this->request->getGetPost('code');
        $data->username = '';

        $company = $this->getCompanyModel()->find($data->cid);
        $errors = [];

        if (!$company) {
            $errors['error'] = 'Akun perusahaan tidak ditemukan.';
        }
        else if ($company->activation_code != $data->code) {
            $errors['error'] = 'Kode aktivasi yang anda masukkan tidak valid';
        }

        if ($this->request->getMethod() == 'post') {
            $data->username = trim((string)$this->request->getPost('username'));
            $data->password1 = trim((string)$this->request->getPost('password1'));
            $data->password2 = trim((string)$this->request->getPost('password2'));

            if (strlen($data->username) < 3) {
                $errors['username'] = 'Username harus diisi, setidaknya 3 karakter.';
            } elseif (strlen($data->username) > 40) {
                $errors['username'] = 'Username terlalu panjang, maksimal 40 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d_]+$/i', $data->username)) {
                $errors['username'] = 'Username tidak valid, gunakan huruf alfabet, angka dan spasi.';
            } else if ($this->getUserModel()->exists($data->username, 0)) {
                $errors['username'] = 'Username sudah digunakan, gunakan nama lain.';
            }

            if (strlen($data->password1) < 5) {
                $errors['password1'] = 'Kata sandi harus diisi, setidaknya 5 karakter.';
            } elseif (strlen($data->password1) > 40) {
                $errors['password1'] = 'Kata sandi terlalu panjang, maksimal 40 karakter.';
            }

            if ($data->password1 != $data->password2) {
                $errors['password2'] = 'Kata sandi tidak cocok.';
            }

            if (empty($errors)) {
                $company->activation_date = current_datetime();
                $company->active = 1;
                $this->getCompanyModel()->save($company);
                
                $user = new User();
                $user->company_id = $company->id;
                $user->username = $data->username;
                $user->fullname = $company->owner_name;
                $user->password = sha1($data->password1);
                $user->active = 1;
                $user->created_at = current_datetime();
                $user->created_by = '__SELF__';
                $user->is_admin = 1;
                $this->getUserModel()->save($user);

                return redirect()->to(base_url('activation-success?username='.$user->username));
            }
        }

        $username = strtolower(str_replace(' ', '', $company->owner_name));

        return view('company/activate', [
            'company' => $company,
            'data' => $data,
            'errors' => $errors,
            'username' => $username
        ]);
    }
}
