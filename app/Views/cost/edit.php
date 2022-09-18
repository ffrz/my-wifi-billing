<?php
$this->title = (!$data->id ? 'Tambah' : 'Edit') . ' Biaya';
$this->menuActive = 'cost';
$this->navActive = 'cost';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="form-group row">
                    <label for="date" class=" col-form-label col-sm-3 required">Tanggal *</label>
                    <div class="col-sm-3">
                        <div class="input-group date" id="date" data-target-input="nearest">
                            <input autofocus type="text" class="form-control datetimepicker-input<?= !empty($errors['date']) ? 'is-invalid' : '' ?>"
                                data-target="#date" name="date" value="<?= format_date($data->date) ?>" />
                            <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <?php if (!empty($errors['date'])) : ?>
                            <span class="error form-error">
                                <?= $errors['date'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="category_id" class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                        <select class="custom-select select2" id="category_id" name="category_id">
                            <option value="" <?= !$data->category_id ? 'selected' : '' ?>>-- Kategori --</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->id ?>" <?= $data->category_id == $category->id ? 'selected' : '' ?>>
                                    <?= esc($category->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-3 col-form-label required">Deskripsi *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= !empty($errors['description']) ? 'is-invalid' : '' ?>"
                            id="description" placeholder="Deskripsi" name="description" value="<?= esc($data->description) ?>">
                        <?php if (!empty($errors['description'])) : ?>
                            <span class="error form-error">
                                <?= $errors['description'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amount" class="col-sm-3 col-form-label required">Jumlah Biaya (Rp.) *</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control text-right <?= !empty($errors['amount']) ? 'is-invalid' : '' ?>" id="amount" name="amount" value="<?= (float)$data->amount ?>">
                        <?php if (!empty($errors['amount'])) : ?>
                            <span class="error form-error">
                                <?= $errors['amount'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
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