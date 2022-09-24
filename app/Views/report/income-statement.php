<?php
$this->title = 'Lap. Laba Rugi';
$this->menuActive = 'report';
$this->navActive = 'report/income-statement';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= "?year=$filter->year&month=$filter->month&print=1" ?>" target="_blank" class="btn plus-btn btn-primary mr-2"><i class="fa fa-print"></i></a>
</li>
<?= $this->endSection() ?>
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
                    <button type="submit" class="btn btn-default mt-2"><i class="fas fa-check"></i></button>
                </div>
            </form>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 table-responsive">
                <h5>Pendapatan Tagihan</h5>
                <table class="table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:1rem;">No</th>
                            <th>Layanan</th>
                            <th style="width:10rem;">Jumlah (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bills)) : ?>
                            <tr>
                                <td colspan="3" class="text-center font-italic">Tidak ada rekaman</td>
                            </tr>
                        <?php endif ?>
                        <?php $total_income = 0 ?>
                        <?php foreach ($bills as $i => $item) : ?>
                            <?php $total_income += $item->total ?>
                            <tr>
                                <td class="text-right"><?= $i + 1 ?></td>
                                <td><?= esc($item->product_name) ?></td>
                                <td class="text-right"><?= format_number($item->total) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="2">Total (Rp.)</th>
                            <th class="text-right"><?= format_number($total_income) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 table-responsive">
                <h5>Biaya Operasional</h5>
                <table class="table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:1rem;">No</th>
                            <th>Kategori</th>
                            <th style="width:10rem;">Jumlah (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($costs)) : ?>
                            <tr>
                                <td colspan="3" class="text-center font-italic">Tidak ada rekaman</td>
                            </tr>
                        <?php endif ?>
                        <?php $total_cost = 0 ?>
                        <?php foreach ($costs as $i => $item) : ?>
                            <?php $total_cost += $item->amount ?>
                            <tr>
                                <td class="text-right"><?= $i + 1 ?></td>
                                <td><?= esc($item->category_name) ?></td>
                                <td class="text-right"><?= format_number($item->amount) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="2">Total (Rp.)</th>
                            <th class="text-right"><?= format_number($total_cost) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table>
                    <tr>
                        <th>Laba / Rugi</th><th>= Pendapatan - Biaya</th>
                    </tr>
                    <tr>
                        <td></td><td>= Rp. <?= format_number($total_income) ?> - Rp. <?= format_number($total_cost) ?></td>
                    </tr>
                    <tr>
                        <td></td><td>= Rp. <?= format_number($total_income - $total_cost) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>