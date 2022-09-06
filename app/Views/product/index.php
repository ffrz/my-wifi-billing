<?php
$this->title = 'Produk';
$this->navActive = 'product';
$this->extend('_layouts/default')
?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('products/add') ?>" class="btn plus-btn btn-primary mr-1" title="Baru"><i class="fa fa-plus"></i></a>
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
                        <label for="active" class="col-form-label col-sm-3">Status</label>
                        <div class="col-sm-9">
                        <select class="custom-select" id="active" name="active">
                            <option value="all" <?= $filter->active == 'all' ? 'selected' : '' ?>>Semua Status</option>
                            <option value="1" <?= $filter->active == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $filter->active == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
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
                            <th>Harga</th>
                            <th>Tagihan</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?= esc($item->name) ?></td>
                                <td class="text-right"><?= format_number($item->price) ?></td>
                                <td class="text-center">Tiap <?= $item->bill_cycle ?> Bulan</td>
                                <td><?= $item->description ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="<?= base_url("/products/view/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/products/edit/$item->id?duplicate=1") ?>" class="btn btn-default btn-sm"><i class="fa fa-copy"></i></a>
                                        <a href="<?= base_url("/products/edit/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Hapus produk?')" href="<?= base_url("/products/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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