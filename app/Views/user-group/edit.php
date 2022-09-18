<?php

use \App\Entities\Acl;

$acl_resources = [
    'Laporan' => [
        Acl::VIEW_REPORTS => 'Melihat Laporan'
    ],
    'Tagihan' => [
        Acl::VIEW_BILLS => 'Melihat daftar tagihan',
        Acl::VIEW_BILL => 'Melihat rincian tagihan',
        Acl::GENERATE_BILLS => 'Men-generate daftar tagihan',
    ],
    'Pelanggan' => [
        Acl::VIEW_CUSTOMERS => 'Melihat daftar pelanggan',
    ],
    'Produk' => [
        Acl::VIEW_PRODUCTS => 'Melihat daftar produk',
    ],
    'Biaya Operasional' => [
        Acl::VIEW_COSTS => 'Melihat daftar biaya operasional',
        Acl::ADD_COST => 'Menambah biaya operasional',
        Acl::EDIT_COST => 'Mengubah biaya operasional',
        Acl::DELETE_COST => 'Menghapus biaya operasional',
    ],
    'Kategori Biaya Operasional' => [        
        Acl::VIEW_COST_CATEGORIES => 'Melihat daftar kategori biaya operasional',
        Acl::ADD_COST_CATEGORY => 'Menambah kategori biaya operasional',
        Acl::EDIT_COST_CATEGORY => 'Mengubah kategori biaya operasional',
        Acl::DELETE_COST_CATEGORY => 'Menghapus kategori biaya operasional',
    ],
];

$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Pengguna';
$this->menuActive = 'system';
$this->navActive = 'user-group';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $data->id ?>">
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-form-label col-sm-3 required">Nama Grup *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" autofocus id="name" placeholder="Masukkan Nama Grup" name="name" value="<?= esc($data->name) ?>">
                        <?php if (!empty($errors['name'])) : ?>
                            <span class="error form-error">
                                <?= $errors['name'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-3">Deskripsi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= !empty($errors['description']) ? 'is-invalid' : '' ?>" id="description" placeholder="Masukkan deskripsi grup" name="description" value="<?= esc($data->description) ?>">
                        <?php if (!empty($errors['description'])) : ?>
                            <span class="error form-error">
                                <?= $errors['description'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <style>
                    custom-control label.acl {
                        font-weight: normal;
                    }
                </style>
                <div class="form-row col-sm-12">
                    <h5>Hak Akses</h5>
                </div>
                <div class="container">
                    <div class="row">
                        <?php foreach ($acl_resources as $category => $resource) : ?>
                            <div class="col">
                                <div class="form-row mt-2">
                                    <b><?= $category ?></b>
                                </div>
                                <?php foreach ($resource as $name => $label) : ?>
                                    <div class="form-row">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="<?= $name ?>" name="acl[<?= $name ?>]" value="1" <?= isset($data->acl[$name]) && $data->acl[$name] ? 'checked="checked"' : '' ?>>
                                            <label class="custom-control-label" style="font-weight:normal; white-space: nowrap;" for="<?= $name ?>"><?= $label ?></label>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>