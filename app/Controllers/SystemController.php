<?php

namespace App\Controllers;

use App\Entities\Acl;

class SystemController extends BaseController
{

    public function settings()
    {
        if (!current_user_can(Acl::CHANGE_SYSTEM_SETTINGS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $company = $this->getCompanyModel()->find(current_user()->company_id);

        $settings = $this->getSettingModel();
        $data = [];
        $errors = [];
        $data['store_name'] = $settings->get('app.store_name', $company->name);
        $data['store_address'] = $settings->get('app.store_address', $company->address);
        
        if ($this->request->getMethod() == 'post') {
            $data['store_name'] = trim($this->request->getPost('store_name'));
            $data['store_address'] = trim($this->request->getPost('store_address'));

            if (strlen($data['store_name']) < 2 || strlen($data['store_name']) > 100) {
                $errors['store_name'] = 'Nama Usaha  harus diisi. Minimal 2 karakter, maksimal 100 karakter.';
            }
            else if (!preg_match('/^[a-zA-Z\d _-]+$/i', $data['store_name'])) {
                $errors['store_name'] = 'Nama Usaha tidak valid, gunakan huruf alfabet, angka atau spasi.';
            }

            if (empty($errors)) {
                $this->db->transBegin();
                $settings->setValue('app.store_name', $data['store_name']);
                $settings->setValue('app.store_address', $data['store_address']);
                $this->db->transCommit();

                return redirect()->to(base_url('system/settings'))->with('info', 'Pengaturan telah disimpan.');
            }
        }
        
        return view('system/settings', [
            'data' => $data,
            'errors' => $errors,
        ]);
    }
    
}
