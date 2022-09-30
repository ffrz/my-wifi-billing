<?php
$this->title = '#' . $bill->code;
?>
<?php $this->extend('_layouts/print-invoice-58') ?>
<?= $this->section('content') ?>
<section class="invoice mb-4">
    <div class="row">
        <div class="col-12">
            <h4 style="margin:0;">
                <i class="fas fa-satellite-dish"></i> <?= esc($settings->get('app.store_name')) ?>
            </h4>
            <p class="font-italic" style="margin:0;"><?= esc($settings->get('app.store_address')) ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="table-responsive">
                <table class="invoice-table pad-xs">
                    <tbody>
                        <tr>
                            <td style="width:100px">No. Invoice</td>
                            <td>:</td>
                            <td style="width:100px">#<?= $bill->code ?></td>
                        </tr>
                        <tr>
                            <td>ID Pelanggan</td>
                            <td>:</td>
                            <td><?= format_customer_id($data->cid) ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pelanggan</td>
                            <td>:</td>
                            <td><?= esc($data->fullname) ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= esc($data->address) ?></td>
                        </tr>
                        <tr>
                            <td>Tagihan Bulan</td>
                            <td>:</td>
                            <td><?= format_date($bill->date, 'MMMM yyyy') ?></td>
                        </tr>
                        <?php if ($product) : ?>
                            <tr>
                                <td>Layanan</td>
                                <td>:</td>
                                <td><?= esc($product->name) ?></td>
                            </tr>
                        <?php endif ?>
                        <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <td><?= esc($bill->description) ?></td>
                        </tr>
                        <tr>
                            <td>Jatuh Tempo</td>
                            <td>:</td>
                            <td><?= format_date($bill->due_date) ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Tagihan</td>
                            <td>:</td>
                            <td>Rp. <?= format_number($bill->amount) ?></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td><?= esc($bill->notes) ?></td>
                        </tr>
                    </tbody>
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