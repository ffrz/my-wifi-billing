<?php

use App\Models\SettingModel;

if ($filter->month != 0) {
    $month = str_pad($filter->month, 2, '0', STR_PAD_LEFT);
    $date = strtotime("$filter->year-$month-01");
    $period = format_date(date('Y-m-d', $date), 'MMMM yyyy');
} else {
    $date = strtotime("$filter->year-01-01");
    $period = format_date(date('Y-m-d', $date), 'yyyy');
}

$settings = new SettingModel();
$this->title = 'Daftar Tagihan';
?>
<?php $this->extend('_layouts/print-invoice') ?>
<?= $this->section('content') ?>
<style>
    @media print {
    @page {
        size: landscape   
    }
}
</style>
<section class="invoice mb-4">
    <div class="row">
        <div class="col-md-12">
            <table class="table-pad-xs table-print table-striped">
                <thead style="text-align:center">
                    <tr class="no-border">
                        <td colspan="7">
                            <h4 style="margin:0">Daftar Tagihan - <?= $period ?></h4>
                            <p style="margin:0"><?= esc($settings->get('app.store_name')) ?></p>
                        </td>
                    </tr>
                    <tr style="background: lightgray;">
                        <th>Invoice #</th>
                        <th>Pelanggan</th>
                        <th>Produk Layanan</th>
                        <th>Tagihan (Rp.)</th>
                        <th>Status</th>
                        <th>WA</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0 ?>
                    <?php foreach ($items as $item) : ?>
                        <?php $total += $item->amount ?>
                        <tr>
                            <td><?= $item->code ?></td>
                            <td><?= format_customer_id($item->cid) ?> - <?= $item->fullname ?></td>
                            <td><?= $item->product_name ?> - <?= format_date($item->date, 'MMMM yyyy') ?></td>
                            <td class="text-right"><?= format_number($item->amount) ?></td>
                            <td class="text-center"><?= format_bill_status($item->status) ?></td>
                            <td class="text-center"><?= $item->wa ?></td>
                            <td><?= $item->address ?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr style="background: lightgray;">
                        <th class="text-right" colspan="3">TOTAL TAGIHAN</th>
                        <th class="text-right"><?= format_number($total) ?></th>
                        <th colspan="3"></th>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="no-border">
                        <td colspan="7"><p><small>Dicetak: <?= current_user()->username ?> | <?= date('Y-m-d H:i:s') ?> - <?= APP_NAME . ' v' . APP_VERSION_STR ?></small></p></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
    <script>
        //window.addEventListener("load", window.print());
    </script>
</section>
<?= $this->endSection() ?>