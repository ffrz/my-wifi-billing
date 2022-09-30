<?php
$this->title = 'Tagihan';
$this->menuActive = 'bill';
$this->navActive = 'bill';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <?php /*
    <a href="<?= base_url('bills/add') ?>" class="btn plus-btn btn-primary mr-1" title="Baru"><i class="fa fa-plus"></i></a>
    */ ?>
    <a target="_blank" href="<?= "?print=2&year=$filter->year&month=$filter->month&status=$filter->status" ?>" title="Cetak Struk" class="btn plus-btn btn-default mr-1"><i class="fa fa-receipt mr"></i></a>
    <a target="_blank" href="<?= "?print=1&year=$filter->year&month=$filter->month&status=$filter->status" ?>" title="Cetak" class="btn plus-btn btn-default mr-1"><i class="fa fa-print mr"></i></a>
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
                        <label for="year" class="col-form-label col-sm-4">Tahun</label>
                        <div class="col-sm-8">
                            <select class="custom-select mt-2" id="year" name="year">
                                <?php for ($year = date('Y'); $year >= 2022; $year--) : ?>
                                    <option value="<?= $year ?>" <?= $filter->year == $year ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="month" class="col-form-label col-sm-4">Bulan</label>
                        <div class="col-sm-8">
                            <select class="custom-select mt-2" name="month">
                                <option value="all" <?= $filter->month == 'all' ? 'selected' : '' ?>>Semua Bulan</option>
                                <option value="1" <?= $filter->month == 1 ? 'selected' : '' ?>>Januari</option>
                                <option value="2" <?= $filter->month == 2 ? 'selected' : '' ?>>Februari</option>
                                <option value="3" <?= $filter->month == 3 ? 'selected' : '' ?>>Maret</option>
                                <option value="4" <?= $filter->month == 4 ? 'selected' : '' ?>>April</option>
                                <option value="5" <?= $filter->month == 5 ? 'selected' : '' ?>>Mei</option>
                                <option value="6" <?= $filter->month == 6 ? 'selected' : '' ?>>Juni</option>
                                <option value="7" <?= $filter->month == 7 ? 'selected' : '' ?>>Juli</option>
                                <option value="8" <?= $filter->month == 8 ? 'selected' : '' ?>>Agustus</option>
                                <option value="9" <?= $filter->month == 9 ? 'selected' : '' ?>>September</option>
                                <option value="10" <?= $filter->month == 10 ? 'selected' : '' ?>>Oktober</option>
                                <option value="11" <?= $filter->month == 11 ? 'selected' : '' ?>>November</option>
                                <option value="12" <?= $filter->month == 12 ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-form-label col-sm-4">Status</label>
                        <div class="col-sm-8">
                            <select class="custom-select mt-2" id="status" name="status">
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
            <div class="col-md-12 table-responsive">
                <table class="data-table display valign-top table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tagihan</th>
                            <th>Pelanggan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url("/bills/view/$item->id") ?>"><?= $item->code ?></a>
                                    <?php if (strtotime(date('Y-m-d')) > strtotime($item->due_date) && $item->status == 0) : ?>
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                    <?php endif ?>
                                    <?php if ($item->status == 1) : ?>
                                        <span class="badge badge-success">Lunas</span>
                                    <?php elseif ($item->status == 2) : ?>
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    <?php elseif ($item->status == 0) : ?>
                                        <span class="badge badge-warning">Belum Dibayar</span>
                                    <?php endif ?>
                                    <?php if ($item->product_id) : ?>
                                        <br><span><?= esc($item->product_name) ?></span>
                                    <?php endif ?>
                                    <span>- <?= format_date($item->date, 'MMMM yyyy') ?></span>
                                    <span>- Rp. <?= format_number($item->amount) ?></span>
                                    <?php if ($item->description) : ?>
                                        <br><?= esc($item->description) ?>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?= format_customer_id($item->cid) ?> - <?= esc($item->fullname) ?>
                                    <br>WA: <?= esc($item->wa) ?>
                                    <br><?= nl2br(esc($item->address)) ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group mr-2">
                                        <?php if ($item->status == 0) : ?>
                                            <a href="<?= base_url("bills/view/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
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
    DATATABLES_OPTIONS.columnDefs = [{ orderable: false, targets: 2 }];
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