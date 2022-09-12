<?php
$this->title = 'Aktivasi Paket Produk';
$this->titleIcon = 'fa-user-plus';
$this->navActive = 'edit-customer';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $customer->id ?>" />
                <div class="form-group row">
                    <label for="username" class="col-sm-3 col-form-label">ID Pelanggan</label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control" id="username" placeholder="ID Pelanggan" name="username" value="<?= esc($customer->username) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fullname" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control" id="fullname" placeholder="Nama Lengkap" name="fullname" value="<?= esc($customer->fullname) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="datetime" class=" col-form-label col-sm-3">Berlaku mulai</label>
                    <div class="col-sm-3">
                        <div class="input-group date" id="datetime" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datetime" name="date" value="<?= esc(format_date($data->date)) ?>" />
                            <div class="input-group-append" data-target="#datetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product" class=" col-form-label col-sm-3">Paket</label>
                    <div class="col-sm-9">
                        <select class="form-control custom-select select2" id="product" name="product_id">
                            <option value="" <?= !$data->product_id ? 'selected' : '' ?>>Tidak Ditentukan</option>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?= $product->id ?>" <?= $data->product_id == $product->id ? 'selected' : '' ?> data-price="<?= $product->price ?>">
                                    <?= esc($product->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class=" col-form-label col-sm-3">Biaya</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control text-right" id="price" name="price" value="<?= esc($data->price) ?>">
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Aktivasi Produk</button>
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
        $('#product').change(function(){
            var selected = $('#product').find(":selected");
            console.log(selected.val());
            if (!selected.val()) {
                return;
            }
            
            $('#price').val(parseInt(selected.data('price')));
        });
    });
</script>
<?= $this->endSection() ?>