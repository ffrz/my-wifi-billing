<?= $this->extend('_layouts/noauth') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body register-card-body">
        <div class="row ml-2 mr-2">
            <div class="col-md-12">
                <h4 class="login-box-msg">Pendaftaran Berhasil</h4>
                <p>
                    Selamat, akun perusahaan <b><?= esc($data->name) ?></b> telah terdaftar pada sistem kami.
                </p>
                <p>Kami akan segera mengirimkan link aktivasi dalam waktu maksimal
                    7x24 jam melalui nomor <b><?= esc($data->phone) ?></b> yang telah anda daftarkan.
                </p>
                <p>
                    Apabila terkendala dengan aktivasi, anda dapat menghubungi customer service kami di nomor Whatsapp
                    <a href="https://wa.me/6285317404760?text=Hi%20CS%20WifiKu" target="_blank">0853-1740-4760</a>
                </p>
                <p>
                    <a href="<?= base_url('login') ?>">&larr; Kembali ke halaman Login.</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>