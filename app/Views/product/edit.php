<?php

use App\Entities\Product;

if ($duplicate) {
    $this->title = 'Duplikat Produk';
} else {
    $this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Produk';
}
$this->navActive = 'product';

?>
<?php $this->extend('_layouts/default') ?>
<?= $this->section('content') ?>
<div class="card card-primary col-md-8">
    <form class="form-horizontal quick-form" method="POST">
        <div class="card-body">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $data->id ?>">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label required">Nama Produk *</label>
                <div class="col-sm-5">
                    <input type="text" autofocus autocomplete="off" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" placeholder="Nama Produk" name="name" value="<?= esc($data->name) ?>">
                </div>
                <?php if (!empty($errors['name'])) : ?>
                    <span class="offset-sm-3 col-sm-9 error form-error">
                        <?= $errors['name'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <input type="text" autocomplete="off" class="form-control" id="description" placeholder="Deskripsi" name="description" value="<?= esc($data->description) ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-3 col-form-label">Harga (Rp.)</label>
                <div class="col-sm-3">
                    <input type="text" autocomplete="off" class="form-control text-right select-all-on-focus <?= !empty($errors['price']) ? 'is-invalid' : '' ?>" id="price" placeholder="Harga" name="price" value="<?= format_number((float)$data->price) ?>">
                </div>
                <?php if (!empty($errors['price'])) : ?>
                    <span class="offset-sm-3 col-sm-9 error form-error">
                        <?= $errors['price'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="bill_period" class="col-sm-3 col-form-label">Periode Tagihan</label>
                <div class="col-sm-3">
                    <select class="custom-select" id="bill_period" name="bill_period"
                    title="Periode tagihan">
                        <option value="1" <?= $data->bill_period == 1 ? 'selected' : '' ?>>Setiap Bulan</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input " id="active" name="active" value="1" <?= $data->active ? 'checked="checked"' : '' ?>>
                        <label class="custom-control-label" for="active" title="Produk aktif dapat digunakan">Aktif</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.select-all-on-focus').focus(function() {this.select();});
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
<?= $this->endSection() ?>