<?php

use App\Models\SettingModel;

$settings = new SettingModel();

$this->title = 'Laporan Biaya Opr.';
?>

<?php $this->extend('_layouts/print-invoice') ?>
<?= $this->section('content') ?>
<section class="invoice mb-4">
    <div class="row">
        <div class="col-12">
            <h6 class="text-center" style="margin:0;"><?= esc($settings->get('app.store_name')) ?></h6>
            <h5 class="text-center" style="margin:0;">LAPORAN PEMBAYARAN TAGIHAN</h5>
            <h6 class="text-center" style="margin:0;"><?= month_names($filter->month) . ' ' . $filter->year ?></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="table-responsive">
                <table class="table table-pad-xs table-bordered" style="width:100%">
                    <thead class="text-center">
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
                                <td><?= $i + 1 ?></td>
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
    <p><small>Dicetak: <?= current_user()->username ?> | <?= date('Y-m-d H:i:s') ?> - <?= APP_NAME . ' v' . APP_VERSION_STR ?></small></p>
    <script>
        window.addEventListener("load", window.print());
    </script>
</section>
<?= $this->endSection() ?>