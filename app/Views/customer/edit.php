<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Pelanggan';
$this->navActive = 'customer';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="cid" class="col-sm-3 col-form-label required">ID Pelanggan *</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control <?= !empty($errors['cid']) ? 'is-invalid' : '' ?>" id="cid" readonly placeholder="ID Pelanggan" value="<?= format_customer_id($data->cid) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fullname" class="col-sm-3 col-form-label required">Nama Lengkap *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= !empty($errors['fullname']) ? 'is-invalid' : '' ?>" id="fullname" placeholder="Nama Lengkap" name="fullname" value="<?= esc($data->fullname) ?>">
                        <?php if (!empty($errors['fullname'])) : ?>
                            <span class="error form-error">
                                <?= $errors['fullname'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="wa_number" class="col-sm-3 col-form-label">No Whatsapp</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="wa_number" placeholder="No Whatsapp" name="wa" value="<?= esc($data->wa) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">No HP</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="phone" placeholder="No HP" name="phone" value="<?= esc($data->phone) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_card_number" class="col-sm-3 col-form-label">No KTP</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="id_card_number" placeholder="No KTP" name="id_card_number" value="<?= esc($data->id_card_number) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class="col-sm-3 col-form-label">Tanggal Pemasangan</label>
                    <div class="col-sm-4">
                        <div class="input-group date" id="date" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#date" name="installation_date" value="<?= format_date($data->installation_date) ?>" />
                            <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="address" placeholder="Alamat" name="address"><?= esc($data->address) ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="notes" class="col-sm-3 col-form-label">Catatan</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="notes" placeholder="Catatan" name="notes"><?= esc($data->notes) ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" <?= $data->status ? 'checked="checked"' : '' ?>>
                            <label class="custom-control-label" for="status">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
<script>
    $(document).ready(function() {
        $('.date').datetimepicker({format: 'DD-MM-YYYY'});
    });
</script>
<?= $this->endSection() ?>