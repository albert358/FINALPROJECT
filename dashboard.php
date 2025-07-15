<?= $this->extend('layouts/cashier_layout') ?>

<?= $this->section('head') ?>
<style>
    .dashboard-welcome {
        color: #333;
    }
    .statistic-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .statistic-card h4 {
        margin-top: 0;
        color: #555;
    }
    .statistic-card p {
        font-size: 1.8em;
        font-weight: bold;
        color: #28a745;
    }
    .activity-item {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
    .activity-item:last-child {
        border-bottom: none;
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Cashier Dashboard</h3>
        <h6 class="op-7 mb-2">Welcome, <?= esc(session()->get('username')) ?>!</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="<?= base_url('cashier/print-receipt') ?>" class="btn btn-label-success btn-round me-2">Print Receipt</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="statistic-card text-center">
            <h4>Orders Today</h4>
            <p>98</p>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="statistic-card text-center">
            <h4>Revenue Today</h4>
            <p>₱12,450</p>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="statistic-card text-center">
            <h4>Refunds</h4>
            <p>3</p>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="statistic-card text-center">
            <h4>Transactions</h4>
            <p>125</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><div class="card-title">Recent Activity</div></div>
            <div class="card-body">
                <div class="activity-item">
                    <strong>Customer A</strong> paid ₱850.00 <span class="float-end text-muted">5 mins ago</span>
                </div>
                <div class="activity-item">
                    <strong>Refund processed</strong> for Order #1212 <span class="float-end text-muted">30 mins ago</span>
                </div>
                <div class="activity-item">
                    POS session started by <strong><?= esc(session()->get('username')) ?></strong> <span class="float-end text-muted">2 hours ago</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><div class="card-title">Daily Revenue</div></div>
            <div class="card-body">
                <div class="chart-container"><canvas id="dailyRevenueChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><div class="card-title">Order Types</div></div>
            <div class="card-body">
                <div class="chart-container"><canvas id="orderTypeChart"></canvas></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Daily Revenue Line Chart
        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue (₱)',
                    data: [2500, 3000, 2800, 4000, 3500, 6000, 7000],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Order Type Pie Chart
        new Chart(document.getElementById('orderTypeChart'), {
            type: 'pie',
            data: {
                labels: ['Dine-in', 'Takeout', 'Delivery'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: ['#ffc107', '#17a2b8', '#6f42c1']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>
