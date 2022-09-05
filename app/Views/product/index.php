<?php
$this->title = 'Produk';
$this->titleIcon = 'fa-cubes';
$this->menuActive = 'inventory';
$this->navActive = 'product';
$this->addButtonLink = [
    'url' => '/products/edit/0',
    'icon' => 'fa-plus',
    'text' => 'Tambah Produk'
];
$this->extend('_layouts/default')
?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('products/edit/0') ?>" class="btn plus-btn btn-primary mr-1" title="Baru"><i class="fa fa-plus"></i></a>
    <button class="btn btn-default plus-btn mr-2" data-toggle="modal" data-target="#modal-sm" title="Saring"><i class="fa fa-filter"></i></button>
</li>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<form method="GET" class="form-horizontal">
    <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Penyaringan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="type" class="col-form-label col-md-3">Jenis</label>
                        <div class="col-sm-9">
                            <select class="custom-select" id="type" name="type">
                                <option value="all" <?= $filter->type == 'all' ? 'selected' : '' ?>>Semua Jenis</option>
                                <option value="0" <?= $filter->type == 0 ? 'selected' : '' ?>>Non Stok</option>
                                <option value="1" <?= $filter->type == 1 ? 'selected' : '' ?>>Stok</option>
                                <option value="2" <?= $filter->type == 2 ? 'selected' : '' ?>>Jasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="active" class="col-form-label col-sm-3">Status</label>
                        <div class="col-sm-9">
                        <select class="custom-select" id="active" name="active">
                            <option value="all" <?= $filter->active == 'all' ? 'selected' : '' ?>>Semua Status</option>
                            <option value="1" <?= $filter->active == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $filter->active == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-form-label col-sm-3">Kategori</label>
                        <div class="col-sm-9">
                        <select class="custom-select select2" id="category_id" name="category_id">
                            <option value="all" <?= $filter->category_id == 'all' ? 'selected' : '' ?>>Semua Kategori</option>
                            <option value="0" <?= $filter->category_id == 0 ? 'selected' : '' ?>>Tidak Ditentukan</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->id ?>" <?= $filter->category_id == $category->id ? 'selected' : '' ?>>
                                    <?= esc($category->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-form-label col-sm-3">Pemasok</label>
                        <div class="col-sm-9">
                        <select class="custom-select select2" id="supplier_id" name="supplier_id">
                            <option value="all" <?= $filter->supplier_id == 'all' ? 'selected' : '' ?>>Semua Supplier</option>
                            <option value="0" <?= $filter->supplier_id == 0 ? 'selected' : '' ?>>Tidak Ditentukan</option>
                            <?php foreach ($suppliers as $supplier) : ?>
                                <option value="<?= $supplier->id ?>" <?= $filter->supplier_id == $supplier->id ? 'selected' : '' ?>>
                                    <?= esc($supplier->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check mr-2"></i> Terapkan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="data-table display table table-bordered table-striped table-condensed center-th">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <?php if (0) : ?>
                                <th>Modal</th>
                            <?php endif ?>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?= esc($item->name) ?></td>
                                <td class="text-center"><?= format_number($item->stock) . ' ' . esc($item->uom) ?></td>
                                <td class="text-right"><?= format_number($item->price) ?></td>
                                <?php if (0) : ?>
                                    <td class="text-right"><?= format_number($item->cost) ?></td>
                                <?php endif ?>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="<?= base_url("/products/view/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/products/duplicate/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-copy"></i></a>
                                        <a href="<?= base_url("/products/edit/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url("/products/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
<script>
    DATATABLES_OPTIONS.order = [
        [0, 'asc']
    ];
    DATATABLES_OPTIONS.columnDefs = [{
        orderable: false,
        targets: 3
    }];
    $(document).ready(function() {
        $('.data-table').DataTable(DATATABLES_OPTIONS);
        $('.select2').select2();
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
<?= $this->endSection() ?>