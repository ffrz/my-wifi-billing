<?php
$this->title = 'Lap. Pembayaran Tagihan';
$this->menuActive = 'report';
$this->navActive = 'report/paid-bills';
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
                    <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-filter"></i></button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?= "?year=$filter->year&month=$filter->month&print=1" ?>" target="_blank" class="btn btn-default mt-2"><i class="fa fa-print mr-2"></i>Print</a>
            </div>
        </div>
    </div>
</div>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Bayar</th>
                            <th>No Tagihan</th>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Bulan</th>
                            <th>Jumlah (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0 ?>
                        <?php foreach ($items as $i => $item) : ?>
                            <?php $total += $item->amount ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td class="text-center"><?= format_date($item->date_complete, 'dd') ?></td>
                                <td><?= $item->code ?></td>
                                <td><?= format_customer_id($item->cid) ?> - <?= esc($item->fullname) ?> - <?= esc($item->address) ?></td>
                                <td class="text-center"><?= esc($item->product_name) ?></td>
                                <td class="text-center"><?= format_date($item->date, 'MMM yyyy') ?></td>
                                <td class="text-right"><?= format_number($item->amount) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="6">Total</th>
                            <th class="text-right"><?= format_number($total) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
