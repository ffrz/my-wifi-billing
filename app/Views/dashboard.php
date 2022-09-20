<?php
$this->title = 'Dashboard';
$this->navActive = 'dashboard';
$year = date('Y');
$month = date('m');
$this->extend('_layouts/default');
?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h4><?= format_number($data->activeCustomer) ?></h4>
                <p>Pelanggan Aktif</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?= base_url('customers?status=1') ?>" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4><?= format_number($data->unpaidBillCount) ?></h4>
                <p>Tagihan Aktif</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-invoice-dollar"></i>
            </div>
            <a href="<?= base_url("bills?year=$year&month=$month&status=0") ?>" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
            <a href="<?= base_url("bills?year=$year&month=$month&status=1") ?>" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fa fa-chart-pie mr-1"></i>
                    Tagihan <?= format_date(date('Y-m-d'), 'MMMM yyyy') ?>
                </h3>
            </div>
            <div class="card-body">
                <canvas id="pieChart" style="min-height: 280px; height: 250px; max-height: 280px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Pendapatan <?= date('Y') ?>
                </h3>
            </div>
            <div class="card-body">
                <canvas class="chart" id="daily-sales" style="max-width: 100%; min-height:280px;"></canvas>
            </div>
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
                borderColor: '#00a65a',
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

    var pieData = {
        labels: [
            'Belum Dibayar',
            'Lunas',
            'Dibatalkan',
        ],
        datasets: [{
            data: [<?= $data->unpaidBill ?>, <?= $data->paidBill ?>, <?= $data->canceledBill ?>],
            backgroundColor: ['#f39c12', '#00a65a', '#f56954'],
        }]
    }

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }

    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })
</script>
<?= $this->endSection() ?>