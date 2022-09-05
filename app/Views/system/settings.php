<?php
$this->title = 'Pengaturan';
$this->navActive = 'system-settings';
$this->titleIcon = 'fa-gear';
$this->menuActive = 'system';
$this->extend('_layouts/default');
?>

<?= $this->section('content') ?>
<div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST">
        <div class="card-body">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label for="store_name" class="col-sm-2 col-form-label">Nama Toko</label>
                <div class="col-sm-10">
                    <input type="text" autofocus class="form-control <?= !empty($errors['store_name']) ? 'is-invalid' : '' ?>"
                        id="store_name" placeholder="Nama Toko" name="store_name" value="<?= esc($data['store_name']) ?>">
                </div>
                <?php if (!empty($errors['store_name'])) : ?>
                    <span class="offset-sm-2 col-sm-10 error form-error">
                        <?= $errors['store_name'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="store_address   " class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="store_address" name="store_address"><?= esc($data['store_address']) ?></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>