<?php
$this->title = 'Tagihan';
$this->navActive = 'bill';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('content') ?>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <form method="GET" class="form-horizontal">
                <div class="form-inline col-md-12">
                    <select class="custom-select mt-2" name="year">
                        <?php for ($year = date('Y'); $year >= 2022; $year--) : ?>
                            <option value="<?= $year ?>" <?= $filter->year == $year ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endfor ?>
                    </select>
                    <select class="custom-select mt-2" name="month">
                        <option value="all" <?= $filter->month == 'all' ? 'selected' : '' ?>>Bulan:</option>
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
                    <select class="custom-select mt-2" id="status" name="status">
                        <option value="all" <?= $filter->status == 'all' ? 'selected' : '' ?>>Status:</option>
                        <option value="0" <?= $filter->status == 0 ? 'selected' : '' ?>>Belum Dibayar</option>
                        <option value="1" <?= $filter->status == 1 ? 'selected' : '' ?>>Lunas</option>
                        <option value="2" <?= $filter->status == 2 ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-filter"></i></button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="btn-group">
                    <a target="_blank" href="<?= "?print=1&year=$filter->year&month=$filter->month&status=$filter->status" ?>" class="btn btn-default"><i class="fa fa-print mr-2"></i> Cetak</a>
                    <a href="<?= base_url('bills/generate') ?>" class="btn btn-warning" title="Generate Tagihan"><i class="fa fa-bolt mr-2"></i> Generate</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive">
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