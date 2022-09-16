<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Perusahaan';
$this->navActive = 'company';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">ID Perusahaan</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="id" readonly placeholder="ID Perusahaan" value="<?= $data->id ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" placeholder="Nama Perusahaan" name="name" value="<?= esc($data->name) ?>">
                        <?php if (!empty($errors['name'])) : ?>
                            <span class="error form-error">
                                <?= $errors['name'] ?>
                            </span>
                        <?php endif ?>
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