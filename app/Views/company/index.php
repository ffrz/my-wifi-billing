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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <?= $item->id ?>
                                </td>
                                <td><?= esc($item->name) ?></td>
                                <td class="text-center">
                                    <div class="btn-group mr-2">
                                        <a href="<?= base_url("/companies/edit/$item->id") ?>" class="btn btn-default btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                                    </div>
                                    <a onclick="return confirm('Hapus Perusahaan?')" href="<?= base_url("/companies/delete/$item->id") ?>" title="Hapus" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
    DATATABLES_OPTIONS.columnDefs = [{ orderable: false, targets: 2 }];
    $(function() {
        $('.data-table').DataTable(DATATABLES_OPTIONS);
    });
</script>
<?= $this->endSection() ?>