<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Tagihan';
$this->menuActive = 'bill';
$this->navActive = 'generate-bill';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="code" class=" col-form-label col-sm-3">No Invoice</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" readonly id="code" value="<?= esc($data->code) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="customer_id" class=" col-form-label col-sm-3">Pelanggan</label>
                    <div class="col-sm-9">
                        <select disabled class="form-control custom-select select2" id="customer_id">
                            <option value="" <?= !$data->customer_id ? 'selected' : '' ?>>--------</option>
                            <?php foreach ($customers as $customer) : ?>
                                <option value="<?= $customer->id ?>" <?= $data->customer_id == $customer->id ? 'selected' : '' ?>
                                    data-product_id="<?= $customer->product_id ?>">
                                    <?= format_customer_id($customer->cid) ?> - <?= esc($customer->fullname) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_id" class=" col-form-label col-sm-3">Layanan</label>
                    <div class="col-sm-9">
                        <select disabled class="form-control custom-select select2" id="product_id">
                            <option value="0" <?= !$data->product_id ? 'selected' : '' ?>>- Layanan -</option>
                            <?php foreach ($products as $product) : ?>
                                <?php if ($product->id != $customer->product_id) continue ?>
                                <option value="<?= $product->id ?>" <?= $data->product_id == $product->id ? 'selected' : '' ?>
                                    data-product_id="<?= $product->id ?>">
                                    <?= esc($product->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class=" col-form-label col-sm-3">Deskripsi</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control <?= !empty($errors['description']) ? 'is-invalid' : '' ?>"
                            id="description" name="description" value="<?= esc($data->description) ?>">
                        <?php if (!empty($errors['description'])) : ?>
                            <span class="error form-error">
                                <?= $errors['description'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amount" class=" col-form-label col-sm-3">Jumlah</label>
                    <div class="col-sm-3">
                    <input type="number" class="form-control text-right <?= !empty($errors['amount']) ? 'is-invalid' : '' ?>"
                            id="amount" name="amount" value="<?= esc($data->amount) ?>">
                        <?php if (!empty($errors['amount'])) : ?>
                            <span class="error form-error">
                                <?= $errors['amount'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class=" col-form-label col-sm-3">Tanggal Tagihan</label>
                    <div class="col-sm-3">
                        <div class="input-group date" id="date" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#date" name="date" value="<?= esc(format_date($data->date)) ?>" />
                            <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="due_date" class=" col-form-label col-sm-3">Tanggal Jatuh Tempo</label>
                    <div class="col-sm-3">
                        <div class="input-group date" id="due_date" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#due_date" name="due_date" value="<?= esc(format_date($data->due_date)) ?>" />
                            <div class="input-group-append" data-target="#due_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="notes" class="col-sm-3 col-form-label">Catatan</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="notes" placeholder="Catatan" name="notes"><?= esc($data->notes) ?></textarea>
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
        $('.date').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('.select2').select2();
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    });
</script>
<?= $this->endSection() ?>