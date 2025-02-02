<?php

include_once "app/models/Dashboard.model.php";

$outstanding = Dashboard::outstanding();

$payments = Dashboard::payments();

$clients = Dashboard::getClientCount();

$invoices = Dashboard::getInvoiceCount();


function formatNumber($number)
{
    return number_format($number, 2, '.', ',');
}

// show(Dashboard::getPayments());


?>



<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Outstanding</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rs.<?= formatNumber($outstanding) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Payments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rs.<?= formatNumber($payments) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Clients</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $clients ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Invoices</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $invoices ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card w-100">
    <div class="card-header">
        Payment overview
    </div>
    <div class="card-body">
        <canvas id="paymentChart" width="600" height="200"></canvas>
    </div>
</div>

<?php
// Your payment data array
$paymentData = Dashboard::chart_data();

// Modify the data format
foreach ($paymentData as &$payment) {
    // Convert month format to "Month Year" format
    $month = date('F Y', strtotime($payment['month'] . '-01'));
    $payment['month'] = $month;
    
    // Format the amount with currency symbol and separators
    $amount = $payment['amount_sum'];
    $payment['amount_sum'] = $amount;
}

// Convert the PHP array to JSON
$paymentDataJSON = json_encode($paymentData);
?>






<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>


<script>
    // Payment data array
    var paymentData = <?= $paymentDataJSON ?>;

    // Extract month labels and amount sums from the payment data
    var months = paymentData.map(function(item) {
        return item.month;
    });

    var amounts = paymentData.map(function(item) {
        return item.amount_sum;
    });

    // Create the bar chart
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var paymentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Total Payments',    
                data: amounts,
                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue color for bars
                borderColor: 'rgba(54, 162, 235, 1)', // Border color for bars
                borderWidth: 1,
                borderRadius: 10 // Border radius for bars
            }]
        },
        options: {
            animation: {
                onComplete: () => {
                    delayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                },
            },
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        }
    });
</script>







<!-- Page level custom scripts -->
<!-- <script src="assets/js/demo/chart-area-demo.js"></script> -->