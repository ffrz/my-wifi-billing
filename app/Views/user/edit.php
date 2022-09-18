<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Pengguna';
$this->menuActive = 'system';
$this->navActive = 'user';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" <?= $data->id ? 'readonly' : '' ?> class="form-control <?= !empty($errors['username']) ? 'is-invalid' : '' ?>" autofocus id="username" placeholder="Username" name="username" value="<?= esc($data->username) ?>">
                        <?php if (!$data->id) : ?>
                            <div class="text-muted">Setelah disimpan username tidak bisa diganti.</div>
                            <?php if (!empty($errors['username'])) : ?>
                                <span class="error form-error">
                                    <?= $errors['username'] ?>
                                </span>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fullname" class="col-sm-4 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control <?= !empty($errors['fullname']) ? 'is-invalid' : '' ?>" id="fullname" placeholder="Nama Lengkap" name="fullname" value="<?= esc($data->fullname) ?>">
                        <?php if (!empty($errors['fullname'])) : ?>
                            <span class="error form-error">
                                <?= $errors['fullname'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="group_id" class="col-sm-4 col-form-label">Grup Pengguna</label>
                    <div class="col-sm-8">
                        <select class="custom-select select2" id="group_id" name="group_id">
                            <option value="" <?= !$data->group_id ? 'selected' : '' ?>>-- Pilih Grup Pengguna --</option>
                            <?php foreach ($userGroups as $group) : ?>
                                <option value="<?= $group->id ?>" <?= $data->group_id == $group->id ? 'selected' : '' ?> title="<?= esc($group->description) ?>">
                                    <?= esc($group->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-4 col-form-label">Kata Sandi</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" id="password" placeholder="Kata Sandi" name="password" value="<?= esc($data->password) ?>">
                        <div class="text-muted">Isi untuk mengganti kata sandi.</div>
                        <?php if (!empty($errors['password'])) : ?>
                            <span class="error form-error">
                                <?= $errors['password'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input " id="active" name="active" value="1" <?= $data->active ? 'checked="checked"' : '' ?>>
                            <label class="custom-control-label" for="active" title="Akun aktif dapat login">Aktif</label>
                        </div>
                        <div class="text-muted">Akun aktif dapat login.</div>
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