<?php

use App\Entities\Product;

if ($duplicate) {
    $this->title = 'Duplikat Produk';
} else {
    $this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Produk';
}
$this->titleIcon = 'fa-cube';
$this->menuActive = 'inventory';
$this->navActive = 'product';
?>
<?php $this->extend('_layouts/default') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST">
        <div class="card-body">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $data->id ?>">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nama Produk</label>
                <div class="col-sm-10">
                    <input type="text" autofocus class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>" id="name" placeholder="Nama" name="name" value="<?= esc($data->name) ?>">
                </div>
                <?php if (!empty($errors['name'])) : ?>
                    <span class="offset-sm-2 col-sm-10 error form-error">
                        <?= $errors['name'] ?>
                    </span>
                <?php endif ?>
            </div>
            <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label">Jenis Produk</label>
                <div class="col-sm-10">
                    <select class="custom-select" id="type" name="type">
                        <option value="<?= Product::TYPE_NON_STOCKED ?>" <?= $data->type == Product::TYPE_NON_STOCKED ? 'selected' : '' ?>>
                            <?= format_product_type(Product::TYPE_NON_STOCKED) ?>
                        </option>
                        <option value="<?= Product::TYPE_STOCKED ?>" <?= $data->type == Product::TYPE_STOCKED ? 'selected' : '' ?>>
                            <?= format_product_type(Product::TYPE_STOCKED) ?>
                        </option>
                        <option value="<?= Product::TYPE_SERVICE ?>" <?= $data->type == Product::TYPE_SERVICE ? 'selected' : '' ?>>
                            <?= format_product_type(Product::TYPE_SERVICE) ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input " id="active" name="active" value="1" <?= $data->active ? 'checked="checked"' : '' ?>>
                        <label class="custom-control-label" for="active" title="Produk aktif dapat dijual">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="category_id" class="col-sm-2 col-form-label">Kategori</label>
                <div class="col-sm-10">
                    <select class="custom-select select2" id="category_id" name="category_id">
                        <option value="" <?= !$data->category_id ? 'selected' : '' ?>>Tidak Ditentukan</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category->id ?>" <?= $data->category_id == $category->id ? 'selected' : '' ?>><?= esc($category->name) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="stock" class="col-sm-2 col-form-label">Stok</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control select-all-on-focus <?= !empty($errors['stock']) ? 'is-invalid' : '' ?>" id="name" placeholder="Stok" name="stock" value="<?= format_number($data->stock) ?>">
                </div>
                <?php if (!empty($errors['stock'])) : ?>
                    <span class="offset-sm-2 col-sm-10 error form-error">
                        <?= $errors['stock'] ?>
                    </span>
                <?php endif ?>
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
            </div>
            <div class="form-group row">
                <label for="notes" class="col-sm-2 col-form-label">Catatan</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="notes" name="notes"><?= esc($data->notes) ?></textarea>
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