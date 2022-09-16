<?php

namespace App\Controllers;

use App\Entities\Company;
use App\Models\CompanyModel;
use CodeIgniter\Database\Exceptions\DataException;

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
}
