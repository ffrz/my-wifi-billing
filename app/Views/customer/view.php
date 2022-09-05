<?php
$this->title = 'Rincian Pelanggan';
$this->titleIcon = 'fa-user';
$this->navActive = 'customer';
$this->menuActive = 'customer';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="customer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tabcontent1-tab1" data-toggle="pill" href="#tabcontent1" role="tab" aria-controls="tabcontent1-tab1" aria-selected="false">Info Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tabcontent2-tab" data-toggle="pill" href="#tabcontent2" role="tab" aria-controls="tabcontent2-tab" aria-selected="true">Riwayat Transaksi</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="customer-tabContent">
            <div class="tab-pane fade show active table-responsive" id="tabcontent1" role="tabpanel" aria-labelledby="tabcontent1-tab1">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td style="width:10rem;">ID Pelanggan</td>
                            <td style="width:1rem;">:</td>
                            <td><?= esc($data->username) ?></td>
                        </tr>
                        <tr>
                            <td style="width:10rem;">Nama Lengkap</td>
                            <td style="width:1rem;">:</td>
                            <td><?= esc($data->fullname) ?></td>
                        </tr>
                        <tr>
                            <td>Alamat Email</td>
                            <td>:</td>
                            <td><?= esc($data->email) ?></td>
                        </tr>
                        <tr>
                            <td>No. Whatsapp</td>
                            <td>:</td>
                            <td><a href="<?= esc(wa_send_url($data->wa)) ?>" target="blank"><?= esc($data->wa) ?></a></td>
                        </tr>
                        <tr>
                            <td>No. HP</td>
                            <td>:</td>
                            <td><?= esc($data->phone) ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= esc($data->address) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><?= $data->status == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tabcontent2" role="tabpanel" aria-labelledby="tabcontent2-tab">
                <div class="overlay-wrapper table-responsive">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No Invoice</th>
                                <th>Tanggal</th>
                                <th>Jenis Transaksi</th>
                                <th>Total</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($salesOrders)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center font-italic text-muted">Belum ada rekaman penjualan.</td>
                                </tr>
                            <?php else: ?>
                            <?php foreach ($salesOrders as $item) : ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="<?= base_url("sales-orders/view/$item->id") ?>">
                                            <?= format_stock_update_code($item->type, $item->code) ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?= format_date($item->datetime) ?></td>
                                    <td class="text-center"><?= format_stock_update_type($item->type) ?></td>
                                    <td class="text-right"><?= format_number($item->total_price) ?></td>
                                    <td><?= esc($item->notes) ?></td>
                                </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?= base_url('/customers') ?>" class="btn btn-default mr-2"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
        <a href="<?= base_url("/customers/edit/$data->id") ?>" class="btn btn-default"><i class="fas fa-edit mr-2"></i>Edit</a>
    </div>
</div>
<?= $this->endSection() ?>