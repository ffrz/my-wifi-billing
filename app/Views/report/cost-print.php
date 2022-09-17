<?php

use App\Models\SettingModel;

$settings = new SettingModel();

$this->title = 'Laporan Biaya Opr.';
?>

<?php $this->extend('_layouts/print-invoice') ?>
<?= $this->section('content') ?>
<section class="invoice mb-4">
    <div class="row">
        <div class="col-12">
            <h6 class="text-center" style="margin:0;"><?= esc($settings->get('app.store_name')) ?></h6>
            <h5 class="text-center" style="margin:0;">RINCIAN LAPORAN BIAYA OPERASIONAL</h5>
            <h6 class="text-center" style="margin:0;"><?= month_names($filter->month) . ' ' . $filter->year ?></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="table-responsive">
                <table class="table table-pad-xs table-bordered" style="width:100%">
                <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)) : ?>
                            <tr>
                                <td colspan="5" class="text-center font-italic">Tidak ada rekaman</td>
                            </tr>
                        <?php endif ?>
                        <?php $total = 0 ?>
                        <?php foreach ($items as $i => $item) : ?>
                            <?php $total += $item->amount ?>
                            <tr>
                                <td class="text-right"><?= $i + 1 ?></td>
                                <td class="text-center"><?= format_date($item->date, 'dd-MM-yyyy') ?></td>
                                <td><?= esc($item->category_name) ?></td>
                                <td><?= esc($item->description) ?></td>
                                <td class="text-right"><?= format_number($item->amount) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="4">Total (Rp.)</th>
                            <th class="text-right"><?= format_number($total) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
    <p><small>Dicetak: <?= current_user()->username ?> | <?= date('Y-m-d H:i:s') ?> - <?= APP_NAME . ' v' . APP_VERSION_STR ?></small></p>
    <script>
        window.addEventListener("load", window.print());
    </script>
</section>
<?= $this->endSection() ?>