<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Kategori Biaya';
$this->menuActive = 'cost';
$this->navActive = 'cost-category';
$this->extend('_layouts/default');
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label required">Nama Kategori *</label>
                    <div class="col-sm-9">
                        <input type="text" autocomplete="off" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" autofocus id="name" placeholder="Nama Kategori Biaya" name="name" value="<?= esc($data->name) ?>">
                        <?php if (!empty($errors['name'])) : ?>
                            <span class="error form-error">
                                <?= $errors['name'] ?>
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