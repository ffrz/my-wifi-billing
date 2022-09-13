<?php
$this->title = ' Generate Tagihan';
$this->navActive = 'bill';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
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
            </div>
            <div class="card-footer">
                <a href="./" class="btn btn-default mr-2"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-money-bill-1-wave mr-2"></i> Generate</button>
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