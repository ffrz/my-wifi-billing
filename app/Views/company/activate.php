<?= $this->extend('_layouts/noauth') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body register-card-body">
        <form action="<?= base_url('activate') ?>" method="post">
            <input type="hidden" name="cid" value="<?= $data->cid ?>">
            <input type="hidden" name="code" value="<?= $data->code ?>">
            <?= csrf_field() ?>
            <div class="row ml-2 mr-2">
                <div class="col-md-12">
                    <h4 class="login-box-msg">Aktivasi Akun Perusahaan</h4>
                    <?php if (empty($errors['error'])) : ?>
                        <p>
                            Selamat datang pemilik akun perusahaan <b><?= esc($company->name) ?></b>.
                        </p>
                        <p>Untuk mengaktifkan akun anda harus membuat
                            username dan kata sandi agar bisa masuk ke sistem kami.
                        </p>
                        <div class="form-group row">
                            <label for="username" class="col-form-label col-sm-4">Username</label>
                            <div class="col-sm-8">
                                <input type="text" id="username" name="username" class="form-control <?= !empty($errors['username']) ? 'is-invalid' : '' ?>" value="<?= esc($data->username) ?>">
                                <div>Rekomendasi: <?= esc($username) ?></div>
                                <?php if (!empty($errors['username'])) : ?>
                                    <div class="error form-error">
                                        <?= $errors['username'] ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password1" class="col-form-label col-sm-4">Kata Sandi</label>
                            <div class="col-sm-8">
                                <input type="password" id="password1" name="password1" class="form-control <?= !empty($errors['password1']) ? 'is-invalid' : '' ?>" value="">
                                <?php if (!empty($errors['password1'])) : ?>
                                    <div class="error form-error">
                                        <?= $errors['password1'] ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password2" class="col-form-label col-sm-4">Ulangi Kata Sandi</label>
                            <div class="col-sm-8">
                                <input type="password" id="password2" name="password2" class="form-control <?= !empty($errors['password2']) ? 'is-invalid' : '' ?>" value="">
                                <?php if (!empty($errors['password2'])) : ?>
                                    <div class="error form-error">
                                        <?= $errors['password2'] ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Buat Akun Pengguna</button>
                            </div>
                        </div>
                        <p class="row mt-4">
                            CS: <a href="https://wa.me/6285317404760?text=Hi%20CS%20WifiKu" target="_blank">0853-1740-4760</a> (Fahmi)
                        </p>
                    <?php else : ?>
                        <p>Mohon maaf, terdapat kesalahan pada saat aktivasi akun perusahaan.</p>
                        <p class="text-danger">Rincian Kesalahan:<br><?= $errors['error'] ?></p>
                    <?php endif ?>
                    <p>
                        <a href="<?= base_url('login') ?>">&larr; Kembali ke halaman Login.</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>