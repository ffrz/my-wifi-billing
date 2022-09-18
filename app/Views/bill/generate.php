<?php
$this->title = ' Generate Tagihan';
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
                    <label for="date" class=" col-form-label col-sm-3">Tahun Tagihan</label>
                    <div class="col-sm-3">
                        <select class="custom-select" name="year">
                            <?php for ($year = date('Y'); $year >= 2022; $year--) : ?>
                                <option value="<?= $year ?>" <?= $data->year == $year ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class=" col-form-label col-sm-3">Bulan Tagihan</label>
                    <div class="col-sm-3">
                    <select class="custom-select" name="month">
                        <option value="1" <?= $data->month == 1 ? 'selected' : '' ?>>Januari</option>
                        <option value="2" <?= $data->month == 2 ? 'selected' : '' ?>>Februari</option>
                        <option value="3" <?= $data->month == 3 ? 'selected' : '' ?>>Maret</option>
                        <option value="4" <?= $data->month == 4 ? 'selected' : '' ?>>April</option>
                        <option value="5" <?= $data->month == 5 ? 'selected' : '' ?>>Mei</option>
                        <option value="6" <?= $data->month == 6 ? 'selected' : '' ?>>Juni</option>
                        <option value="7" <?= $data->month == 7 ? 'selected' : '' ?>>Juli</option>
                        <option value="8" <?= $data->month == 8 ? 'selected' : '' ?>>Agustus</option>
                        <option value="9" <?= $data->month == 9 ? 'selected' : '' ?>>September</option>
                        <option value="10" <?= $data->month == 10 ? 'selected' : '' ?>>Oktober</option>
                        <option value="11" <?= $data->month == 11 ? 'selected' : '' ?>>November</option>
                        <option value="12" <?= $data->month == 12 ? 'selected' : '' ?>>Desember</option>
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="due_date" class=" col-form-label col-sm-3">Tanggal Jatuh Tempo</label>
                    <div class="col-sm-3">
                        <div class="input-group date" id="due_date" data-target-input="nearest">
                            <input type="number" min="1" max="25" class="form-control" name="due_date" value="<?= 20 ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning"><i class="fas fa-bolt mr-2"></i> Generate</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
<script>
    $(document).ready(function() {
    });
</script>
<?= $this->endSection() ?>