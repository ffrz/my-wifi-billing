<?php

use \App\Entities\Acl;

$acl_resources = [
    'Pengelolaan Grup Pengguna' => [
        Acl::VIEW_USER_GROUPS => 'Melihat Daftar Grup Pengguna',
        Acl::VIEW_USER_GROUP => 'Melihat Grup Pengguna',
        Acl::ADD_USER_GROUP => 'Menambahkan Grup Pengguna',
        Acl::EDIT_USER_GROUP => 'Mengubah Grup Pengguna',
        Acl::DELETE_USER_GROUP => 'Menghapus Grup Pengguna',
    ],
    'Pengelolaan Pengguna' => [
        Acl::VIEW_USERS => 'Melihat Daftar Pengguna',
        Acl::VIEW_USER => 'Melihat Pengguna',
        Acl::ADD_USER => 'Menambahkan Pengguna',
        Acl::EDIT_USER => 'Mengubah Pengguna',
        Acl::DELETE_USER => 'Menghapus Pengguna',
    ],
];

$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Pengguna';
$this->titleIcon = 'fa-user';
$this->menuActive = 'users';
$this->navActive = 'user-group';
$this->extend('_layouts/default')
?>

<?= $this->section('content') ?>
<div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $data->id ?>">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name">Nama Grup</label>
                    <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" autofocus id="name" placeholder="Masukkan Nama Grup" name="name" value="<?= esc($data->name) ?>">
                    <?php if (!empty($errors['name'])) : ?>
                        <span class="error form-error">
                            <?= $errors['name'] ?>
                        </span>
                    <?php endif ?>
                </div>
                <div class="form-group col-md-8">
                    <label for="description">Deskripsi</label>
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
            <div class="form-row col-md-12">
                <h4>Hak Akses</h4>
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
                            <input type="checkbox" class="custom-control-input" id="<?= $name ?>" name="acl[<?= $name ?>]" value="1" <?= $data->acl[$name] ? 'checked="checked"' : '' ?>>
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
<?= $this->endSection() ?>