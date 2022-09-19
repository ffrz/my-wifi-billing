<?php
$this->title = 'Perusahaan';
$this->navActive = 'company';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('companies/add') ?>" class="btn plus-btn btn-primary mr-1" title="Baru"><i class="fa fa-plus"></i></a>
    <button class="btn btn-default plus-btn mr-2" data-toggle="modal" data-target="#modal-sm" title="Saring"><i class="fa fa-filter"></i></button>
</li>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive" >
                <table class="data-table display table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Pemilik</th>
                            <th>No WA</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr <?= $item->activation_code ? 'class="bg-warning"' : '' ?>>
                                <td><?= $item->id ?></td>
                                <td><?= esc($item->name) ?></td>
                                <td><?= esc($item->owner_name) ?></td>
                                <td><?= esc($item->phone) ?></td>
                                <td><?= esc($item->address) ?></td>
                                <td><?= $item->active ? 'Aktif' : 'Non Aktif' ?></td>
                                <td class="text-center">
                                    <div class="btn-group mr-2">
                                        <a href="<?= base_url("/companies/view/$item->id") ?>" class="btn btn-default btn-sm" title="Rincian"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/companies/edit/$item->id") ?>" class="btn btn-default btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Nonaktifkan Perusahaan?')" href="<?= base_url("/companies/delete/$item->id") ?>" title="Nonaktifkan" class="btn btn-default btn-sm"><i class="fa fa-ban"></i></a>
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
    DATATABLES_OPTIONS.order = [[0, 'asc']];
    DATATABLES_OPTIONS.columnDefs = [{ orderable: false, targets: 5 }];
    $(function() {
        $('.data-table').DataTable(DATATABLES_OPTIONS);
    });
</script>
<?= $this->endSection() ?>