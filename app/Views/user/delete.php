<?php
$this->title = 'Hapus Pengguna';
$this->menuActive = 'system';
$this->navActive = 'user';
$this->extend('_layouts/default')
?>

<?= $this->section('content') ?>
<div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $data->id ?>">
        <div class="card-body">
            <h4>Konfirmasi Penghapusan Akun Pengguna</h4>
            <p>Anda benar-benar akan menghapus akun pengguna <b><?= esc($data->username) ?></b>?</p>
            <table>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><?= esc($data->username) ?></td>
                </tr>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><?= esc($data->fullname) ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><?= $data->active ? 'Aktif' : 'Non Aktif' ?></td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <div>
                <a href="<?= base_url("/users") ?>" class="btn btn-default mr-2"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-can mr-1"></i> HAPUS PERMANEN</button>
            </div>
        </div>
    </form>
</div>
</div>
<?= $this->endSection() ?>