<?php
$this->title = 'Pelanggan';
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
            <div class="col-md-12 table-responsive">
                <table class="data-table display valign-top table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <?= format_customer_id($item->cid) ?> - <?= esc($item->fullname) ?>
                                    <?php if ($item->status == 0) : ?>
                                        <sup><span class="badge badge-danger">Non Aktif</span></sup>
                                    <?php endif ?>
                                    <?php if ($item->wa) : ?>
                                        <br>WA: <?= esc($item->wa) ?>
                                    <?php endif ?>
                                    <br><?= nl2br(esc($item->address)) ?>
                                </td>
                                <td>
                                    <?php if ($item->product_id) : ?>
                                        <?= esc($item->product_name) ?><br>
                                        Rp. <?= format_number($item->product_price) ?> / <?= $item->bill_period ?> bulan
                                    <?php endif ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?= base_url("/customers/view/$item->id") ?>" class="btn btn-default btn-sm" title="Lihat rincian"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/customers/edit/$item->id") ?>" class="btn btn-default btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                                        <?php if ($item->status == 1) : ?>
                                            <a href="<?= base_url("/customers/activate-product/$item->id") ?>" class="btn btn-warning btn-sm" title="Ganti layanan"><i class="fa fa-satellite-dish mr-1"></i> Aktivasi</a>
                                        <?php endif ?>
                                        <a onclick="return confirm('Hapus pelanggan?')" href="<?= base_url("/customers/delete/$item->id") ?>" title="Hapus / nonaktifkan" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
        targets: 2
    }];
    $(function() {
        $('.data-table').DataTable(DATATABLES_OPTIONS);
    });
</script>
<?= $this->endSection() ?>