<?= $this->extend('_layouts/noauth') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body register-card-body ml-2 mr-2">
        <h4 class="login-box-msg">Pendaftaran dan Aktivasi Berhasil</h4>
        <p>
            Selamat, akun pengguna <b><?= esc($username) ?></b> telah aktif.
            Anda sekarang dapat login menggunakan akun ini.
        </p>
        <p>
            <a class="btn btn-block btn-primary" href="<?= base_url("login?username=$username") ?>"><i class="fa fa-right-to-bracket mr-2"></i>Login / Masuk Sekarang</a>
        </p>
        <p>
            Apabila terkendala login, anda dapat menghubungi customer service kami di nomor Whatsapp
            <a href="https://wa.me/6285317404760?text=Hi+CS+WifiKu" target="_blank">0853-1740-4760</a> (Fahmi)
        </p>
    </div>
</div>
<?= $this->endSection() ?>