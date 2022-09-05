<?php
$this->title = 'Rincian Produk';
$this->titleIcon = 'fa-cube';
$this->navActive = 'product';
$this->menuActive = 'inventory';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="product-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tabcontent1-tab1" data-toggle="pill" href="#tabcontent1" role="tab" aria-controls="tabcontent1-tab1" aria-selected="false">Info Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tabcontent2-tab" data-toggle="pill" href="#tabcontent2" role="tab" aria-controls="tabcontent2-tab" aria-selected="true">Riwayat Transaksi</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="product-tabContent">
            <div class="tab-pane fade show active" id="tabcontent1" role="tabpanel" aria-labelledby="tabcontent1-tab1">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td style="width:10rem;">Nama Produk</td>
                            <td style="width:1rem;">:</td>
                            <td><?= esc($data->name) ?></td>
                        </tr>
                        <tr>
                            <td>Jenis</td>
                            <td>:</td>
                            <td><?= format_product_type($data->type) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><?= ($data->active ? 'Aktif' : 'Tidak Aktif') ?></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td><?= ($data->category ? esc($data->category->name) : '-') ?></td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td>:</td>
                            <td><?= format_number($data->stock) . ' ' . esc($data->uom) ?></td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td>:</td>
                            <td>Rp. <?= format_number($data->cost) ?></td>
                        </tr>
                        <tr>
                            <td>Harga Jual</td>
                            <td>:</td>
                            <td>Rp. <?= format_number($data->price) ?></td>
                        </tr>
                        <tr>
                            <td>Metode Penentuan Modal</td>
                            <td>:</td>
                            <td><?= format_product_costing_method($data->costing_method) ?></td>
                        </tr>
                        <tr>
                            <td>Pemasok</td>
                            <td>:</td>
                            <td><?= ($data->supplier ? esc($data->supplier->name) : '-') ?></td>
                        </tr>
                        <tr>
                            <td>Pemasok Terakhir</td>
                            <td>:</td>
                            <td><?= ($data->last_supplier ? esc($data->last_supplier->name) : '-') ?></td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td><?= esc($data->notes) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tabcontent2" role="tabpanel" aria-labelledby="tabcontent2-tab">
                <div class="overlay-wrapper">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>Invoice #</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Pihak</th>
                                <th colspan="2">Kwantitas</th>
                                <th>Modal</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($stockUpdates)): ?>
                                <tr><td colspan="8" class="text-center font-italic text-muted">Belum ada rekaman transaksi.</td></tr>
                            <?php endif ?>
                            <?php foreach ($stockUpdates as $item): ?>
                                <tr>
                                    <td class="text-center"><?= format_stock_update_code($item->type, $item->code) ?></td>
                                    <td class="text-center"><?= format_date($item->datetime) ?></td>
                                    <td class="text-center"><?= format_stock_update_type($item->type) ?></td>
                                    <td><?= esc($item->party_name) ?></td>
                                    <td class="text-right"><?= format_number($item->quantity) ?></td>
                                    <td><?= esc($data->uom) ?></td>
                                    <td class="text-right"><?= format_number($item->cost) ?></td>
                                    <td class="text-right"><?= format_number($item->price) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?= base_url('/products/') ?>" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
    </div>
</div>
<?= $this->endSection() ?>