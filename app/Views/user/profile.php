<?php
$this->title = 'Profil Saya';
$this->titleIcon = 'fa-user';
$this->menuActive = 'users';
$this->navActive = 'profile';
$this->extend('_layouts/default')
?>

<?= $this->section('content') ?>
<div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST">
        <div class="card-body">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="username">Username</label>
                    <input type="text" class="form-control <?= !empty($errors['username']) ? 'is-invalid' : '' ?>"
                        id="username" readonly value="<?= esc($data->username) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" class="form-control <?= !empty($errors['fullname']) ? 'is-invalid' : '' ?>"
                        autofocus id="fullname" placeholder="Nama Lengkap" name="fullname" value="<?= esc($data->fullname) ?>">
                    <?php if (!empty($errors['fullname'])) : ?>
                        <span class="error form-error">
                            <?= $errors['fullname'] ?>
                        </span>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="password1">Kata Sandi <span class="text-muted">(Isi untuk mengganti kata sandi.)</span></label>
                    <input type="password" class="form-control" id="password1" name="password1" value="<?= esc($data->password1) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="password2">Ulangi Kata Sandi<span class="text-muted"></span></label>
                    <input type="password" class="form-control <?= !empty($errors['password2']) ? 'is-invalid' : '' ?>"
                        id="password2" placeholder="Kata Sandi" name="password2" value="<?= esc($data->password2) ?>">
                    <?php if (!empty($errors['password2'])) : ?>
                        <span class="error form-error">
                            <?= $errors['password2'] ?>
                        </span>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <div class="custom-control custom-checkbox">
                        <input disabled type="checkbox" class="custom-control-input " id="active" <?= $data->active ? 'checked="checked"' : '' ?>>
                        <label class="custom-control-label" for="active">Aktif</label>
                    </div>
                </div>
                <div class="form-group col-md-2">
                <div class="custom-control custom-checkbox">
                        <input disabled type="checkbox" class="custom-control-input " id="is_admin" <?= $data->is_admin ? 'checked="checked"' : '' ?>>
                        <label class="custom-control-label" for="is_admin">Administrator</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div>
                <a href="<?= base_url('/users/') ?>" class="btn btn-default mr-2"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
            </div>
        </div>
    </form>
</div>
</div>
<?= $this->endSection() ?>