<?php
$this->title = 'Tagihan';
$this->navActive = 'bill';
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
                        <label for="daterange" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="daterange" class="form-control float-right" id="daterange" value="<?= format_date($filter->dateStart) . ' - ' . format_date($filter->dateEnd) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-form-label col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <select class="custom-select" id="status" name="status">
                                <option value="all" <?= $filter->status == 'all' ? 'selected' : '' ?>>Semua Status</option>
                                <option value="0" <?= $filter->status == 0 ? 'selected' : '' ?>>Belum Dibayar</option>
                                <option value="1" <?= $filter->status == 1 ? 'selected' : '' ?>>Lunas</option>                                
                                <option value="2" <?= $filter->status == 2 ? 'selected' : '' ?>>Dibatalkan</option>
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
                <table class="data-table display valign-top table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tagihan</th>
                            <th>Pelanggan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url("/bills/view/$item->id") ?>">
                                        <?= $item->code ?>
                                    </a>
                                    <?php if ($item->due_date > date('Y-m-d') && $item->status == 0): ?>
                                        <span class="badge badge-warning">Jatuh Tempo</span>
                                    <?php endif ?>
                                    <?php if ($item->status == 1): ?>
                                        <span class="badge badge-success">Lunas</span>
                                    <?php elseif ($item->status == 2): ?>
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    <?php endif ?>
                                    <?php if ($item->product_id): ?>
                                        <br><span><?= esc($item->product_name) ?></span>
                                    <?php endif ?>
                                    <?php if ($item->description): ?>
                                        <br><?= esc($item->description) ?>
                                    <?php endif ?>
                                    <br>Rp. <?= format_number($item->amount) ?>
                                </td>
                                <td>
                                    <?= esc($item->username) ?> - <?= esc($item->fullname) ?>
                                    <br>WA: <?= esc($item->wa) ?>
                                    <br><?= nl2br(esc($item->address)) ?>
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
    $(function() {
        $('.data-table').DataTable(DATATABLES_OPTIONS);
        $('#daterange').daterangepicker({
            locale: {
                format: DATE_FORMAT
            }
        });
    });
</script>
<?= $this->endSection() ?>