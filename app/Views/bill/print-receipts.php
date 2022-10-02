<?php

use App\Models\SettingModel;

$settings = new SettingModel();
if ($filter->month != 0) {
    $month = str_pad($filter->month, 2, '0', STR_PAD_LEFT);
    $date = strtotime("$filter->year-$month-01");
    $period = format_date(date('Y-m-d', $date), 'MMMM yyyy');
} else {
    $date = strtotime("$filter->year-01-01");
    $period = format_date(date('Y-m-d', $date), 'yyyy');
}

$this->title = 'Cetak Tagihan ' . $period;

?>
<?php $this->extend('_layouts/print-invoice') ?>
<?= $this->section('content') ?>
<style>
    @media print {
        @page {
            size: portrait;
        }
    }

    .m0a {
        margin: 0 auto;
    }

    .m0 {
        margin: 0;
    }

    .tc {
        text-align: center;
    }

    .fi {
        font-style: italic;
    }

    .tr {
        text-align: right;
    }

    .invoice-table td {
        vertical-align: top;
    }

    .invoice-table {
        width: 100%;
    }

    .invoice-table td:first-child {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .invoice-container {
        display: inline-block;
        border: 1px solid #333;
        padding: 5px;
        width: 30%;
        margin: 5px;
    }
</style>
<section class="invoice mb-4" style="width:210mm;margin:0 auto;">
    <?php foreach ($items as $i => $bill) : ?>
        <div class="invoice-container">
            <h4 class="m0 tc"><i class="fas fa-satellite-dish mr-2"></i><?= esc($settings->get('app.store_name')) ?></h4>
            <p class="fi m0 tc"><?= esc($settings->get('app.store_address')) ?></p>
            <table class="invoice-table pad-xs m0a">
                <tbody>
                    <tr>
                        <td class="tr">No. Invoice</td>
                        <td>:</td>
                        <td>#<?= $bill->code ?></td>
                    </tr>
                    <tr>
                        <td class="tr">ID Pel</td>
                        <td>:</td>
                        <td><?= format_customer_id($bill->cid) ?></td>
                    </tr>
                    <tr>
                        <td class="tr">Nama Pel</td>
                        <td>:</td>
                        <td><?= esc($bill->fullname) ?></td>
                    </tr>
                    <tr>
                        <td class="tr">Alamat</td>
                        <td>:</td>
                        <td><?= esc($bill->address) ?></td>
                    </tr>
                    <tr>
                        <td class="tr">Tagihan Bln</td>
                        <td>:</td>
                        <td><?= format_date($bill->date, 'MMMM yyyy') ?></td>
                    </tr>
                    <tr>
                        <td class="tr">Layanan</td>
                        <td>:</td>
                        <td><?= esc($bill->product_name) ?></td>
                    </tr>
                    <tr>
                        <td class="tr">Jml Tagihan</td>
                        <td>:</td>
                        <td>Rp. <?= format_number($bill->amount) ?></td>
                    </tr>
                </tbody>
            </table>
            <p class="m0 tc"><small>Dicetak: <?= current_user()->username ?> | <?= date('Y-m-d H:i:s') ?><br><?= APP_NAME . ' v' . APP_VERSION_STR ?></small></p>
        </div>
    <?php endforeach ?>
</section>
<?= $this->endSection() ?>