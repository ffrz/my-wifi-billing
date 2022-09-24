<?php

use App\Models\SettingModel;

$settings = new SettingModel();
$this->title = 'Laporan Laba / Rugi';

?>
<?php $this->extend('_layouts/print-invoice') ?>
<?= $this->section('content') ?>
<section class="invoice mb-4" style="width:80%;margin: 0 auto;">
    <div class="row">
        <div class="col-12">
            <h6 class="text-center" style="margin:0;"><?= esc($settings->get('app.store_name')) ?></h6>
            <h5 class="text-center" style="margin:0;">LAPORAN LABA / RUGI</h5>
            <h6 class="text-center" style="margin:0;"><?= month_names($filter->month) . ' ' . $filter->year ?></h6>
        </div>
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
                    <th>Laba / Rugi</th>
                    <th>= Pendapatan - Biaya</th>
                </tr>
                <tr>
                    <td></td>
                    <td>= Rp. <?= format_number($total_income) ?> - Rp. <?= format_number($total_cost) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>= Rp. <?= format_number($total_income - $total_cost) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <p><small>Dicetak: <?= current_user()->username ?> | <?= date('Y-m-d H:i:s') ?> - <?= APP_NAME . ' v' . APP_VERSION_STR ?></small></p>
    <script>
        window.addEventListener("load", window.print());
    </script>
</section>
<?= $this->endSection() ?>