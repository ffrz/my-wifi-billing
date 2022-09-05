<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Pelanggan';
$this->titleIcon = 'fa-user-plus';
$this->navActive = 'edit-customer';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-6">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" placeholder="Nama" name="name" value="<?= esc($data->name) ?>">
                        <?php if (!empty($errors['name'])) : ?>
                            <span class="error form-error">
                                <?= $errors['name'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contacts" class="col-sm-3 col-form-label">Kontak</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="contacts" placeholder="Kontak" name="contacts" value="<?= esc($data->contacts) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="form-group col-sm-9">
                        <textarea class="form-control" id="address" placeholder="Alamat" name="address"><?= esc($data->address) ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group col-sm-9 offset-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" <?= $data->active ? 'checked="checked"' : '' ?>>
                            <label class="custom-control-label" for="active">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>