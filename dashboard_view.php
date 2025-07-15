<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('head') ?>
    <style>
        .dashboard-welcome {
            color: #333;
        }
        /* Add more specific styles for dashboard widgets here */
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
            color: #007bff; /* Example color */
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
            height: 300px; /* Adjust height as needed */
            width: 100%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
        <div>
            <h3 class="fw-bold mb-3">Admin Dashboard</h3> <h6 class="op-7 mb-2">Welcome to your Admin Panel</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="#" class="btn btn-label-info btn-round me-2">Settings</a>
            <a href="#" class="btn btn-primary btn-round">Quick Action</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Main Content Area for Admin Dashboard</div> </div>
                <div class="row mt-4">
                    <div class="col-sm-6 col-md-3">
                        <div class="statistic-card text-center">
                            <h4>Total Orders</h4>
                            <p>1,234</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="statistic-card text-center">
                            <h4>Revenue Today</h4>
                            <p>$5,678.90</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="statistic-card text-center">
                            <h4>New Users</h4>
                            <p>87</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="statistic-card text-center">
                            <h4>Pending Tasks</h4>
                            <p>12</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12"> <div class="card">
                            <div class="card-header">
                                <div class="card-title">Recent Activity</div>
                            </div>
                            <div class="card-body">
                                <div class="activity-item">
                                    <strong>John Doe</strong> placed a new order (#1001).
                                    <span class="float-end text-muted">2 mins ago</span>
                                </div>
                                <div class="activity-item">
                                    New user <strong>Jane Smith</strong> registered.
                                    <span class="float-end text-muted">1 hour ago</span>
                                </div>
                                <div class="activity-item">
                                    Product "Awesome Gadget" updated by <strong>Admin</strong>.
                                    <span class="float-end text-muted">3 hours ago</span>
                                </div>
                                <div class="activity-item">
                                    Payment for order #998 received.
                                    <span class="float-end text-muted">Yesterday</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Monthly Sales Overview</div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="monthlySalesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Product Categories Distribution</div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="categoryDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">User Registrations Over Time</div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="userRegistrationsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function() {
            console.log("Dashboard page scripts loaded!");

            // Initialize Monthly Sales Chart (Line Chart)
            const monthlySalesCtx = document.getElementById('monthlySalesChart');
            new Chart(monthlySalesCtx, {
                type: 'line', // You can also use 'bar' for a bar chart
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Sales ($)',
                        data: [1200, 1900, 3000, 5000, 2000, 3000, 4500, 6000, 5500, 7000, 8000, 9500],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3, // Makes the line curved
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allows chart-container to control height
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales Amount'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                }
            });

            // Initialize Product Categories Distribution Chart (Pie Chart)
            const categoryDistributionCtx = document.getElementById('categoryDistributionChart');
            new Chart(categoryDistributionCtx, {
                type: 'pie',
                data: {
                    labels: ['Electronics', 'Apparel', 'Home Goods', 'Books', 'Food'],
                    datasets: [{
                        label: 'Product Distribution',
                        data: [30, 20, 25, 15, 10], // Percentages or counts
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right', // or 'top', 'bottom', 'left'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + '%'; // Assuming data is percentage
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Initialize User Registrations Chart (Bar Chart)
            const userRegistrationsCtx = document.getElementById('userRegistrationsChart');
            new Chart(userRegistrationsCtx, {
                type: 'bar',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
                    datasets: [{
                        label: 'New Registrations',
                        data: [50, 75, 60, 90, 80],
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Users'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false, // Often hidden for single bar charts
                        }
                    }
                }
            });
        });
    </script>
<?= $this->endSection() ?>