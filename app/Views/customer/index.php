<?php
$this->title = 'Pelanggan';
$this->titleIcon = 'fa-users';
$this->navActive = 'customer';
?>
<?= $this->extend('_layouts/default') ?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('customers/add') ?>" class="btn plus-btn btn-primary mr-2" title="Baru"><i class="fa fa-plus"></i></a>
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
                            <th>Nama</th>
                            <th>Paket</th>
                            <th>WA</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?= esc($item->username) ?></td>
                                <td><?= esc($item->fullname) ?></td>
                                <td><?= esc('') ?></td>
                                <td><?= esc($item->wa) ?></td>
                                <td><?= esc($item->address) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?= base_url("/customers/view/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url("/customers/edit/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url("/customers/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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