<?php
$this->title = 'Profil Saya';
$this->titleIcon = 'fa-user';
$this->menuActive = 'users';
$this->navActive = 'profile';
$this->extend('_layouts/default')
?>

<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="username" class="col-form-label col-sm-4">Username</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="username" readonly value="<?= esc($data->username) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-4">
                    <div class="custom-control custom-checkbox">
                        <input disabled type="checkbox" class="custom-control-input " id="is_admin" <?= $data->is_admin ? 'checked="checked"' : '' ?>>
                        <label class="custom-control-label" for="is_admin">Administrator</label>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fullname" class="col-form-label col-sm-4">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control <?= !empty($errors['fullname']) ? 'is-invalid' : '' ?>" autofocus id="fullname" placeholder="Nama Lengkap" name="fullname" value="<?= esc($data->fullname) ?>">
                        <?php if (!empty($errors['fullname'])) : ?>
                            <span class="error form-error">
                                <?= $errors['fullname'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="current_password" class="col-form-label col-sm-4">Kata Sandi Sekarang</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control <?= !empty($errors['current_password']) ? 'is-invalid' : '' ?>" id="current_password" name="current_password" value="<?= esc($data->current_password) ?>">
                        <?php if (!empty($errors['current_password'])) : ?>
                            <span class="error form-error">
                                <?= $errors['current_password'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password1" class="col-form-label col-sm-4">Kata Sandi Baru</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control <?= !empty($errors['password1']) ? 'is-invalid' : '' ?>" id="password1" name="password1" value="<?= esc($data->password1) ?>">
                        <span class="text-muted">(Isi untuk mengganti kata sandi.)</span>
                        <?php if (!empty($errors['password1'])) : ?>
                            <span class="error form-error">
                                <?= $errors['password1'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password2" class="col-form-label col-sm-4">Ulangi Kata Sandi Baru</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control <?= !empty($errors['password2']) ? 'is-invalid' : '' ?>" id="password2" placeholder="Kata Sandi" name="password2" value="<?= esc($data->password2) ?>">
                        <?php if (!empty($errors['password2'])) : ?>
                            <span class="error form-error">
                                <?= $errors['password2'] ?>
                            </span>
                        <?php endif ?>
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