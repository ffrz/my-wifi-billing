<?php
$this->title = 'Rincian Perusahaan';
$this->navActive = 'company';
$this->extend('_layouts/default');
$activation_link = base_url('activate') . "/$data->id/$data->activation_code";
$text_activation = "Hi " . esc($data->owner_name) . ", untuk aktifasi akun " . APP_NAME . ' '
    . esc($data->name) . ' silahkan klik tautan ' . $activation_link;

$phone = (string)$data->phone;
$phone = '62' . substr($phone, 1, strlen($phone));
?>
<?= $this->section('content') ?>
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="customer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tabcontent1-tab1" data-toggle="pill" href="#tabcontent1" role="tab" aria-controls="tabcontent1-tab1" aria-selected="false">Info Perusahaan</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="customer-tabContent">
            <div class="tab-pane show active fade table-responsive" id="tabcontent1" role="tabpanel" aria-labelledby="tabcontent1-tab1">
                <table class="table table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td style="width:10rem;">ID Perusahaan</td>
                            <td style="width:1rem;">:</td>
                            <td><?= $data->id ?></td>
                        </tr>
                        <tr>
                            <td>Nama Perusahaan</td>
                            <td>:</td>
                            <td><?= esc($data->name) ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pemilik</td>
                            <td>:</td>
                            <td><?= esc($data->owner_name) ?></td>
                        </tr>
                        <tr>
                            <td>No Whatsapp</td>
                            <td>:</td>
                            <td><a target="_blank" href="<?= wa_send_url($phone) ?>"><?= $data->phone ?></a></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><?= $data->active ? 'Aktif' : 'Non Aktif' ?></td>
                        </tr>
                        <?php if ($data->activation_code) : ?>
                            <tr>
                                <td>Teks Aktifasi</td>
                                <td>:</td>
                                <td><?= $text_activation ?></td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="btn-group mr-2">
            <a href="<?= base_url("/companies/edit/$data->id") ?>" class="btn btn-default"><i class="fas fa-edit mr-2"></i>Edit</a>
            <?php if ($data->activation_code) : ?>
                <a target="_blank" href="<?= wa_send($phone, $text_activation) ?>" class="btn btn-warning"><i class="fas fa-paper-plane mr-2"></i>Kirim Link Aktifasi</a>
            <?php endif ?>
            <?php if ($data->active) : ?>
            <a onclick="return confirm('Nonaktifkan?')" href="<?= base_url("/companies/delete/$data->id") ?>" class="btn btn-default"><i class="fas fa-ban mr-2"></i>Nonaktifkan</a>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>