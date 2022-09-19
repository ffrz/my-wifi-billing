<?= $this->extend('_layouts/noauth') ?>
<?= $this->section('content') ?>
<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg">Pendaftaran Perusahaan</p>
        <form action="<?= base_url('register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label for="name" class="col-form-label col-sm-4">Nama Usaha</label>
                <div class="col-sm-8">
                    <input type="text" id="name" name="name" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>"
                        placeholder="Nama Usaha" value="<?= esc($data->name) ?>">
                    <?php if (!empty($errors['name'])) : ?>
                    <span class="error form-error">
                        <?= $errors['name'] ?>
                    </span>
                <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="owner_name" class="col-form-label col-sm-4">Nama Pemilik</label>
                <div class="col-sm-8">
                    <input type="text" id="owner_name" name="owner_name" class="form-control <?= !empty($errors['owner_name']) ? 'is-invalid' : '' ?>"
                        placeholder="Nama Pemilik" value="<?= esc($data->owner_name) ?>">
                    <?php if (!empty($errors['owner_name'])) : ?>
                    <span class="error form-error">
                        <?= $errors['owner_name'] ?>
                    </span>
                <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-form-label col-sm-4">No WA / HP</label>
                <div class="col-sm-8">
                    <input type="text" id="phone" name="phone" class="form-control <?= !empty($errors['phone']) ? 'is-invalid' : '' ?>"
                        placeholder="Contoh: 081200001111" value="<?= esc($data->phone) ?>">
                    <?php if (!empty($errors['phone'])) : ?>
                    <span class="error form-error">
                        <?= $errors['phone'] ?>
                    </span>
                <?php endif ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-form-label col-sm-4">Alamat</label>
                <div class="col-sm-8">
                    <textarea class="form-control <?= !empty($errors['phone']) ? 'is-invalid' : '' ?>"
                        d="address" name="address"><?= esc($data->address) ?></textarea>
                    <?php if (!empty($errors['address'])) : ?>
                    <span class="error form-error">
                        <?= $errors['address'] ?>
                    </span>
                <?php endif ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <a href="<?= base_url('login') ?>" class="text-center">&larr; Kembali ke halaman Masuk</a>
                </div>
            </div>
        </form>

    </div>
</div>
<?= $this->endSection() ?>