<?php
$this->title = 'Pengguna';
$this->titleIcon = 'fa-users';
$this->menuActive = 'system';
$this->navActive = 'users';
$this->extend('_layouts/default')
?>
?>
<?= $this->section('right-menu') ?>
<li class="nav-item">
    <a href="<?= base_url('users/edit/0') ?>" class="btn plus-btn btn-primary mr-2" title="Baru"><i class="fa fa-plus"></i></a>
</li>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="data-table display table table-bordered table-striped table-condensed center-th" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Status</th>
                            <th>Grup</th>
                            <th class="text-center" style="max-width:10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td>
                                    <?= esc($item->username) ?>
                                    <?php if ($item->is_admin): ?>
                                        <span class="badge badge-warning">Administrator</span>
                                    <?php endif ?>
                                </td>
                                <td><?= esc($item->fullname) ?></td>
                                <td><?= $item->active ? 'Aktif' : 'Nonaktif' ?></td>
                                <td><?= esc($item->group_name) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?= base_url("/users/edit/$item->id") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url("/users/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
        DATATABLES_OPTIONS.columnDefs = [{ orderable: false, targets: 2 }];
        $('.data-table').DataTable(DATATABLES_OPTIONS);
    });
</script>
<?= $this->endSection() ?>