<?php
$this->title = 'Dashboard';
$this->titleIcon = 'fa-tachometer-alt';
$this->navActive = 'dashboard';
$this->extend('_layouts/default')
?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cart-shopping"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a href="<?= base_url('sales-orders') ?>">Penjualan Hari ini</a></span>
                <span class="info-box-number">Rp. <?= format_number(1000000000) ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-screwdriver-wrench"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a href="<?= base_url('service-orders?active=1') ?>">Servis Aktif</a></span>
                <span class="info-box-number"><?= format_number(11) ?> order</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-trend-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Penjualan Bulan ini</span>
                <span class="info-box-number">Rp. <?= format_number(1000000000) ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-screwdriver-wrench"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Servis Bulan ini</span>
                <span class="info-box-number">Rp. <?= format_number(1000000000) ?></span>
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
                    Penjualan Bulan Ini
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
    var mydata = <?= json_encode([]) ?>;

    const myChart = new Chart($('#daily-sales'), {
    type: 'line',
    data: {
        labels: mydata.days,
        datasets: [{
            label: 'Omset',
            data: mydata.sales,
            borderWidth: 2,
            fill: false,
            borderColor: 'rgb(255, 0, 0)',
            tension: 0.1
        }, {
            label: 'Modal',
            data: mydata.costs,
            borderWidth: 2,
            fill: false,
            borderColor: 'rgb(0, 0, 255)',
            tension: 0.1
        }, {
            label: 'Keuntungan',
            data: mydata.revenues,
            borderWidth: 2,
            fill: false,
            borderColor: 'rgb(0, 255, 0)',
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
                        callback: function (value) {
                            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&.');
                        }
                    }
                }]
            }
    }
});
</script>
<?= $this->endSection() ?>