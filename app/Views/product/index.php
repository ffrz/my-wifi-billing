<?php
$this->title = 'Layanan';
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
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Penyaringan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="active" class="col-form-label col-sm-4">Status</label>
                        <div class="col-sm-8">
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
                            <th>Nama Layanan</th>
                            <th>Biaya (Rp.)</th>
                            <th>Pelanggan</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <?= esc($item->name) ?>
                                    <?php if (!$item->active) : ?>
                                        <span class="badge badge-danger">Non Aktif</span>
                                    <?php endif ?>
                                </td>
                                <td class="text-right"><?= format_number($item->price) ?> / <?= $item->bill_period == 1 ? '' : $item->bill_period  ?> bulan</td>
                                <td class="text-center"><?= $item->customer_count ?></td>
                                <td><?= $item->description ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="<?= base_url("/products/edit/$item->id?duplicate=1") ?>" class="btn btn-default btn-sm" title="Duplikat layanan"><i class="fa fa-copy"></i></a>
                                        <a href="<?= base_url("/products/edit/$item->id") ?>" class="btn btn-default btn-sm" title="Ubah layanan"><i class="fa fa-edit"></i></a>
                                        <?php if ($item->active): ?>
                                            <a onclick="return confirm('Hapus layanan?')" href="<?= base_url("/products/delete/$item->id") ?>" title="Hapus layanan" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        <?php endif ?>
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
        targets: 4
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