<?php
$this->title = 'Dashboard';
$this->navActive = 'dashboard';
$this->extend('_layouts/default')
?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a href="<?= base_url('customers?status=1') ?>">Pelanggan Aktif</a></span>
                <span class="info-box-number"><?= format_number($data->activeCustomer) ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-satellite-dish"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a href="<?= base_url('products?active=1') ?>">Produk Aktif</a></span>
                <span class="info-box-number"><?= format_number($data->activeProduct) ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bills"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tagihan</span>
                <span class="info-box-number"><?= format_number($data->unpaidBillCount) ?> / Rp. <?= format_number($data->unpaidBill) ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pemasukan Bulan ini</span>
                <span class="info-box-number">Rp. <?= format_number($data->paidBill) ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Pendapatan <?= date('Y') ?>
                </h3>
            </div>
            <div class="card-body">
                <canvas class="chart" id="daily-sales" style="max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
<script src="<?= base_url('plugins/chart.js/Chart.min.js') ?>"></script>
<script>
    var mydata = <?= json_encode($data->incomes) ?>;

    const myChart = new Chart($('#daily-sales'), {
        type: 'line',
        data: {
            labels: mydata.months,
            datasets: [{
                label: 'Pendapatan',
                data: mydata.incomes,
                borderWidth: 2,
                fill: false,
                borderColor: 'rgb(255, 0, 0)',
                tension: 0.1
            }]
        },
        options: {
            locale: 'id-ID',
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.');
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.');
                        }
                    }
                }]
            }
        }
    });
</script>
<?= $this->endSection() ?>