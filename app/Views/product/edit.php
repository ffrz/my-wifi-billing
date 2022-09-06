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
                <label for="name" class="col-sm-3 col-form-label">Nama Produk</label>
                <div class="col-sm-5">
                    <input type="text" autofocus class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" placeholder="Nama Produk" name="name" value="<?= esc($data->name) ?>">
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
                    <input type="text" class="form-control" id="description" placeholder="Deskripsi" name="description" value="<?= esc($data->description) ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-3 col-form-label">Harga</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-right select-all-on-focus <?= !empty($errors['price']) ? 'is-invalid' : '' ?>" id="price" placeholder="Harga" name="price" value="<?= format_number((float)$data->price) ?>">
                </div>
                <?php if (!empty($errors['price'])) : ?>
                    <span class="offset-sm-3 col-sm-9 error form-error">
                        <?= $errors['price'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="bill_cycle" class="col-sm-3 col-form-label">Siklus Tagihan</label>
                <div class="col-sm-3">
                    <select class="custom-select" id="bill_cycle" name="bill_cycle"
                    title="Siklus tagihan">
                        <option value="1" <?= $data->cycle == 1 ? 'selected' : '' ?>>Setiap Bulan</option>
                        <?php  /*
                        <option value="3" <?= $data->cycle == 3 ? 'selected' : '' ?>>Setiap 3 Bulan</option>
                        <option value="6" <?= $data->cycle == 6 ? 'selected' : '' ?>>Setiap 6 Bulan</option>
                        <option value="12" <?= $data->cycle == 12 ? 'selected' : '' ?>>Setiap 12 Bulan</option>
                        */ ?>
                    </select>
                </div>
            </div>
            <?php /*
            <div class="form-group row">
                <label for="notify_before" class="col-sm-3 col-form-label">Pemberitahuan</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control text-right select-all-on-focus"
                        id="notify_before" placeholder="Notifikasi" name="notify_before" value="<?= $data->notify_before ?>" min="1" max="30">
                </div>
            </div>
            <div class="form-group row">
                <label for="uom" class="col-sm-2 col-form-label">Satuan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control <?= !empty($errors['uom']) ? 'is-invalid' : '' ?>" id="uom" placeholder="Satuan" name="uom" value="<?= esc($data->uom) ?>">
                </div>
                <?php if (!empty($errors['uom'])) : ?>
                    <span class="offset-sm-2 col-sm-10 error form-error">
                        <?= $errors['uom'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="costing-method" class="col-sm-2 col-form-label">Penentuan Modal</label>
                <div class="col-sm-10">
                    <select class="custom-select" id="costing-method" name="costing_method"
                    title="Pilih cara menentukan modal dari produk ini">
                        <option value="0" <?= $data->costing_method == 0 ? 'selected' : '' ?>>Harga Beli Manual</option>
                        <option value="1" <?= $data->costing_method == 1 ? 'selected' : '' ?>>Harga Beli Terakhir</option>
                        <option value="2" <?= $data->costing_method == 2 ? 'selected' : '' ?>>Harga Beli Rata-Rata</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cost" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control select-all-on-focus <?= !empty($errors['cost']) ? 'is-invalid' : '' ?>" id="cost" placeholder="Modal" name="cost" value="<?= format_number($data->cost) ?>">
                </div>
                <?php if (!empty($errors['cost'])) : ?>
                    <span class="offset-sm-2 col-sm-10 error form-error">
                        <?= $errors['cost'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-2 col-form-label">Harga Jual</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control select-all-on-focus <?= !empty($errors['price']) ? 'is-invalid' : '' ?>" id="price" placeholder="Harga Jual" name="price" value="<?= format_number($data->price) ?>">
                </div>
                <?php if (!empty($errors['price'])) : ?>
                    <span class="offset-sm-2 col-sm-10 error form-error">
                        <?= $errors['price'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="supplier_id" class="col-sm-2 col-form-label">Pemasok</label>
                <div class="col-sm-10">
                    <select class="custom-select select2" id="supplier_id" name="supplier_id">
                        <option value="" <?= !$data->supplier_id ? 'selected' : '' ?>>Tidak Ditentukan</option>
                        <?php foreach ($suppliers as $supplier) : ?>
                            <option value="<?= $supplier->id ?>" <?= $data->supplier_id == $supplier->id ? 'selected' : '' ?>>
                                <?= esc($supplier->name) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div> */ ?>
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
            <a href="<?= base_url('/products') ?>" class="btn btn-default mr-2"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
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