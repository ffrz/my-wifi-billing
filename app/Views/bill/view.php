<?php
    $this->title = 'Rincian Tagihan #' . $bill->code;
    $this->navActive = 'bill';
    $this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="card card-primary">
    <div class="card-header p-0 pt-1">
    </div>
    <div class="card-body">
        <div class="tab-content" id="customer-tabContent">
            <div class="tab-pane fade show active table-responsive" id="tabcontent1" role="tabpanel" aria-labelledby="tabcontent1-tab1">
                <table class="table table-condensed pad-xs">
                    <tbody>
                        <tr>
                            <td>No. Invoice</td>
                            <td>:</td>
                            <td><?= $bill->code ?></td>
                        </tr>
                        <tr>
                            <td style="width:10rem;">ID Pelanggan</td>
                            <td style="width:1rem;">:</td>
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
                            <td>Bulan</td>
                            <td>:</td>
                            <td><?= format_date($bill->date, 'MMMM yyyy') ?></td>
                        </tr>
                        <?php if ($product): ?>
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
                            <td>Status</td>
                            <td>:</td>
                            <td><?= ($bill->status == 1 ? 'Lunas' : 'Belum Lunas') ?></td>
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
    <div class="card-footer">
    <form method="post" action="<?= base_url('bills/process') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $bill->id ?>" />
        <div class="btn-group mr-2">
            <a href="<?= base_url('/bills') ?>" class="btn btn-default"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
            <a href="?print=1" class="btn btn-default" target="_blank"><i class="fas fa-print mr-2"></i>Cetak</a>
            <?php if ($bill->status == 0): ?>
            <a href="<?= base_url("/bills/edit/$bill->id") ?>" class="btn btn-default"><i class="fas fa-edit mr-2"></i>Edit</a>
            <?php endif ?>
        </div>
        <?php if ($bill->status == 0): ?>
        <div class="btn-group mr-2">
            <button type="submit" name="action" value="fully_paid" onclick="return confirm('Bayar?');" class="btn btn-primary"><i class="fas fa-check mr-2"></i>Bayar Lunas</button>
            <button type="submit" name="action" value="cancel" onclick="return confirm('Batalkan Tagihan?');" class="btn btn-warning mr-2"><i class="fas fa-cancel mr-2"></i>Batalkan Tagihan</button>
        </div>
        <a onclick="return confirm('Hapus?');" href="<?= base_url("/bills/delete/$bill->id") ?>" class="btn btn-danger"><i class="fas fa-trash mr-2"></i>Hapus</a>
        <?php endif ?>
    </form>
    </div>
</div>
<?= $this->endSection() ?>