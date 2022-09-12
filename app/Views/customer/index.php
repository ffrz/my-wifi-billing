<?php
$this->title = 'Pelanggan';
$this->titleIcon = 'fa-users';
$this->navActive = 'customer';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('customers/add') ?>" class="btn plus-btn btn-primary mr-1" title="Baru"><i class="fa fa-plus"></i></a>
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
                        <label for="status" class="col-form-label col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <select class="custom-select" id="status" name="status">
                                <option value="all" <?= $filter->status == 'all' ? 'selected' : '' ?>>Semua Status</option>
                                <option value="1" <?= $filter->status == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $filter->status == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
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
            <div class="col-md-12 table-responsive" >
                <table class="data-table display table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Paket</th>
                            <th>Biaya (Rp.)</th>
                            <th>WA</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <?= esc($item->username) ?>
                                    <?php if ($item->status == 0): ?>
                                        <sup><span class="badge badge-danger">Non Aktif</span></sup>
                                    <?php endif ?>
                                </td>
                                <td><?= esc($item->fullname) ?></td>
                                <td class="text-center">
                                    <?php if ($item->product_id): ?>
                                        <?= esc($item->product_name) ?>
                                    <?php elseif ($item->status == 1): ?>
                                        <a href="<?= base_url("/customers/activate-product/$item->id") ?>" class="btn btn-primary btn-sm">Aktifkan Paket</a>
                                    <?php else: ?>
                                        <span class="text-muted font-italic">Tidak Ada</span>
                                    <?php endif ?>
                                </td>
                                <td class="text-right"><?= format_number($item->product_price) ?></td>
                                <td><?= esc($item->wa) ?></td>
                                <td class="text-center">
                                    <div class="btn-group mr-2">
                                        <a href="<?= base_url("/customers/view/$item->id") ?>" class="btn btn-default btn-sm" title="Lihat rincian"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/customers/edit/$item->id") ?>" class="btn btn-default btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                                        <?php if ($item->status == 1): ?>
                                            <a href="<?= base_url("/customers/activate-product/$item->id") ?>" class="btn btn-warning btn-sm" title="Ubah paket produk"><i class="fa fa-satellite-dish"></i></a>
                                        <?php endif ?>
                                    </div>
                                    <a onclick="return confirm('Hapus pelanggan?')" href="<?= base_url("/customers/delete/$item->id") ?>" title="Hapus / nonaktifkan" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
    DATATABLES_OPTIONS.order = [[0, 'asc']];
    DATATABLES_OPTIONS.columnDefs = [{ orderable: false, targets: 5 }];
    $(function() {
        $('.data-table').DataTable(DATATABLES_OPTIONS);
    });
</script>
<?= $this->endSection() ?>