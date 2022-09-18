<?php
    $this->title = 'Rincian Pelanggan';
    $this->navActive = 'customer';
    $this->extend('_layouts/default');
?>
<?= $this->section('content') ?>
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="customer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tabcontent1-tab1" data-toggle="pill" href="#tabcontent1" role="tab" aria-controls="tabcontent1-tab1" aria-selected="false">Info Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tabcontent2-tab" data-toggle="pill" href="#tabcontent2" role="tab" aria-controls="tabcontent2-tab" aria-selected="true">Riwayat Tagihan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tabcontent3-tab" data-toggle="pill" href="#tabcontent3" role="tab" aria-controls="tabcontent2-tab" aria-selected="true">Riwayat Aktivasi Produk</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="customer-tabContent">
            <div class="tab-pane show active fade table-responsive" id="tabcontent1" role="tabpanel" aria-labelledby="tabcontent1-tab1">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td style="width:10rem;">ID Pelanggan</td>
                            <td style="width:1rem;">:</td>
                            <td><?= format_customer_id($data->cid) ?></td>
                        </tr>
                        <tr>
                            <td style="width:10rem;">Nama Lengkap</td>
                            <td style="width:1rem;">:</td>
                            <td><?= esc($data->fullname) ?></td>
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
                        <?php if ($data->product_id): ?>
                        <tr>
                            <td>Produk Aktif</td>
                            <td>:</td>
                            <td><?= esc($data->product_name) ?></td>
                        </tr>
                        <tr>
                            <td>Tagihan</td>
                            <td>:</td>
                            <td>Rp. <?= format_number($data->product_price) ?></td>
                        </tr>
                        <?php else: ?>
                            <tr>
                                <td>Paket Produk</td>
                                <td>:</td>
                                <td>Silahkan aktifkan produk</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
                <h5>Info Rekaman</h5>
                <?php if ($data->created_at): ?>
                    <p>Dibuat oleh <?= esc($data->created_by) ?> pada <?= format_datetime($data->created_at) ?></p>
                <?php endif ?>
                <?php if ($data->updated_at): ?>
                    <p>Diperbarui oleh <?= esc($data->updated_by) ?> pada <?= format_datetime($data->updated_at) ?></p>
                <?php endif ?>
                <?php if ($data->deleted_at): ?>
                    <p>Dihapus oleh <?= esc($data->deleted_by) ?> pada <?= format_datetime($data->deleted_at) ?></p>
                <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tabcontent2" role="tabpanel" aria-labelledby="tabcontent2-tab">
                <div class="overlay-wrapper table-responsive">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No Invoice</th>
                                <th>Bulan</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data->bills)) : ?>
                                <tr>
                                    <td colspan="6" class="text-center font-italic text-muted">Belum ada rekaman tagihan.</td>
                                </tr>
                            <?php else: ?>
                            <?php foreach ($data->bills as $item) : ?>
                                <tr>
                                    <td><?= $item->code ?></td>
                                    <td><?= format_date($item->date, 'MMMM yyyy') ?></td>
                                    <td><?= $item->product_name ?></td>
                                    <td><?= format_number($item->amount) ?></td>
                                    <td><?= format_bill_status($item->status) ?></td>
                                    <td><?= $item->notes ?></td>
                                </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="tabcontent3" role="tabpanel" aria-labelledby="tabcontent3-tab">
                <div class="overlay-wrapper table-responsive">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr class="text-center">
                            <th>Tanggal</th>
                            <th>Paket Produk</th>
                            <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data->productActivations)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center font-italic text-muted">Belum ada rekaman aktivasi.</td>
                                </tr>
                            <?php else: ?>
                            <?php foreach ($data->productActivations as $item) : ?>
                                <tr>
                                    <td class="text-center"><?= format_date($item->date) ?></td>
                                    <td><?= esc($item->product_name) ?></td>
                                    <td class="text-right"><?= format_number($item->price) ?></td>
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
        <div class="btn-group mr-2">
            <a href="<?= base_url('/customers') ?>" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
            <a href="<?= base_url("/customers/edit/$data->id") ?>" class="btn btn-default"><i class="fas fa-edit mr-2"></i>Edit</a>
            <a href="<?= base_url("/customers/activate-product/$data->id") ?>" class="btn btn-warning"><i class="fas fa-satellite-dish mr-2"></i>Ganti Produk</a>
            <a href="<?= base_url("/customers/delete/$data->id") ?>" class="btn btn-danger"><i class="fas fa-trash mr-2"></i>Hapus</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>