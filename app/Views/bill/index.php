<?php
$this->title = 'Tagihan';
$this->navActive = 'customer';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
<a href="<?= base_url('bills/generate') ?>" class="btn btn-primary mr-1" title="Generate Tagihan"><i class="fa fa-money-bill-1-wave mr-2"></i> GENERATE</a>
    <a href="<?= base_url('bills/add') ?>" class="btn plus-btn btn-primary mr-1" title="Baru"><i class="fa fa-plus"></i></a>
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
                                <option value="1" <?= $filter->status == 1 ? 'selected' : '' ?>>Lunas</option>
                                <option value="0" <?= $filter->status == 0 ? 'selected' : '' ?>>Belum Dibayar</option>
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
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Deskripsi</th>
                            <th>Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?= $item->code ?></td>
                                <td>
                                    <?= esc($item->username) ?> - <?= esc($item->fullname) ?>
                                    <br>WA: <?= esc($item->wa) ?>
                                    <br><?= nl2br(esc($item->address)) ?>
                                </td>
                                <td><?= esc($item->description) ?></td>
                                <td class="text-right"><?= format_number($item->amount) ?></td>
                                <td><?= format_date($item->due_date) ?></td>
                                <td class="text-center">
                                    <div class="btn-group mr-2">
                                        <a href="<?= base_url("/bills/view/$item->id") ?>" class="btn btn-default btn-sm" title="Lihat rincian"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/bills/edit/$item->id") ?>" class="btn btn-default btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                                    </div>
                                    <a onclick="return confirm('Hapus Tagihan?')" href="<?= base_url("/bills/delete/$item->id") ?>" title="Hapus" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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