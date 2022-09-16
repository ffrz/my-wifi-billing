<?php
$this->title = 'Biaya Operasional';
$this->navActive = 'cost';
$this->extend('_layouts/default')
?>
?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('costs/add') ?>" class="btn plus-btn btn-primary mr-2" title="Baru"><i class="fa fa-plus"></i></a>
</li>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <form method="GET" class="form-horizontal">
                <div class="form-inline col-md-12">
                    <select class="custom-select mt-2" name="year">
                        <?php for ($year = date('Y'); $year >= 2022; $year--) : ?>
                            <option value="<?= $year ?>" <?= $filter->year == $year ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endfor ?>
                    </select>
                    <select class="custom-select mt-2" name="month">
                        <option value="all" <?= $filter->month == 'all' ? 'selected' : '' ?>>Bulan:</option>
                        <option value="1" <?= $filter->month == 1 ? 'selected' : '' ?>>Januari</option>
                        <option value="2" <?= $filter->month == 2 ? 'selected' : '' ?>>Februari</option>
                        <option value="3" <?= $filter->month == 3 ? 'selected' : '' ?>>Maret</option>
                        <option value="4" <?= $filter->month == 4 ? 'selected' : '' ?>>April</option>
                        <option value="5" <?= $filter->month == 5 ? 'selected' : '' ?>>Mei</option>
                        <option value="6" <?= $filter->month == 6 ? 'selected' : '' ?>>Juni</option>
                        <option value="7" <?= $filter->month == 7 ? 'selected' : '' ?>>Juli</option>
                        <option value="8" <?= $filter->month == 8 ? 'selected' : '' ?>>Agustus</option>
                        <option value="9" <?= $filter->month == 9 ? 'selected' : '' ?>>September</option>
                        <option value="10" <?= $filter->month == 10 ? 'selected' : '' ?>>Oktober</option>
                        <option value="11" <?= $filter->month == 11 ? 'selected' : '' ?>>November</option>
                        <option value="12" <?= $filter->month == 12 ? 'selected' : '' ?>>Desember</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-filter"></i></button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
            <a href="<?= base_url('cost-categories/') ?>" class="btn btn-default mr-2" title="Kelola Kategori"><i class="fa fa-folder mr-2"></i> Kelola Kategori</a>
            </div>
        </div>
    </div>
</div>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="data-table display table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Biaya (Rp.)</th>
                            <th style="width:40%;">Deskripsi</th>
                            <th class="text-center" style="max-width:10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td class="text-center"><?= format_date($item->date) ?></td>
                                <td class="text-center"><?= esc($item->category_name) ?></td>
                                <td class="text-right"><?= format_number($item->amount) ?></td>
                                <td><?= esc($item->description) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?= base_url("/costs/edit/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Hapus Biaya?')" href="<?= base_url("/costs/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
<script>
    $(function() {
        DATATABLES_OPTIONS.order = [[0, 'asc']];
        DATATABLES_OPTIONS.columnDefs = [{ orderable: false, targets: 4 }];
        $('.data-table').DataTable(DATATABLES_OPTIONS);
    });
</script>
<?= $this->endSection() ?>