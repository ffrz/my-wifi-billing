<?php

namespace App\Controllers;

class SystemController extends BaseController
{

    public function settings()
    {
        $settings = $this->getSettingModel();
        $data = [];
        $errors = [];
        $data['store_name'] = $settings->get('app.store_name', 'Toko Saya');
        $data['store_address'] = $settings->get('app.store_address', '');
        
        if ($this->request->getMethod() == 'post') {
            $data['store_name'] = trim($this->request->getPost('store_name'));
            $data['store_address'] = trim($this->request->getPost('store_address'));

            if (strlen($data['store_name']) == 0) {
                $errors['store_name'] = 'Nama usaha harus diisi.';
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
