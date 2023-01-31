<?php
  $page_title = "Dashboard";
  require_once 'includes/header.php';

  $customers_growth = get_customers_growth();
  $orders_growth = get_orders_growth();
  $revenue_last_2_months = get_revenue_last_2_months();
  $revenue_growth_all_months = get_revenue_growth_all_months();
?>
<div class="row">
    <div class="col-12">
        <h1 class='display-5 m-3'><?= $page_title; ?></h1>
        <hr>
    </div>
</div>

<div class='row mb-5'>
    <div class='col'>
        <div class='card text-secondary-emphasis bg-secondary-subtle border border-success-subtle mx-3'>
            <div class='card-body'>
                <div class='float-end'>
                    <i class='bi bi-people fs-1'></i>
                </div>
                <h5 class='text-muted fw-normal mt-0' title='Number of Customers'>Customers</h5>
                <h3 class='mt-3 mb-3'><?= $customers_growth['Nr_Customers']; ?></h3>
                <p class='mb-0 text-muted'>
                        <span class='text-success me-2'><i class='bi bi-arrow-bar-up'></i>
                          <?= number_format($customers_growth['NewSinceLastMonth'] / $customers_growth['Nr_Customers'] * 100, 2); ?>%</span>
                    <span class='text-nowrap'>From last month</span>
                </p>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <div class='col'>
        <div class='card text-secondary-emphasis bg-secondary-subtle border border-success-subtle mx-3'>
            <div class='card-body'>
                <div class='float-end'>
                    <i class='bi bi-cart-check fs-1'></i>
                </div>
                <h5 class='text-muted fw-normal mt-0' title='Number of Customers'>Orders</h5>
                <h3 class='mt-3 mb-3'><?= $orders_growth['Nr_Orders']; ?></h3>
                <p class='mb-0 text-muted'>
                        <span class='text-success me-2'><i class='bi bi-arrow-bar-up'></i>
                        <?= number_format($orders_growth['NewSinceLastMonth'] / $orders_growth['Nr_Orders'] * 100, 2); ?>%</span>
                    <span class='text-nowrap'>From last month</span>
                </p>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <div class='col'>
        <div class='card text-secondary-emphasis bg-secondary-subtle border border-success-subtle mx-3'>
            <div class='card-body'>
                <div class='float-end'>
                    <i class='bi bi-cash-coin fs-1'></i>
                </div>
                <h5 class='text-muted fw-normal mt-0' title='Number of Customers'>Revenue</h5>
                <h3 class='mt-3 mb-3'>&euro;<?= $revenue_last_2_months[0]['Month_Revenue']; ?></h3>
                <p class='mb-0 text-muted'>
                        <span class='text-success me-2'><i class='bi bi-arrow-bar-up'></i>
                            <?= number_format($revenue_last_2_months[0]['Month_Revenue'] / $revenue_last_2_months[1]['Month_Revenue'] * 100,
                              2); ?>%</span>
                    <span class='text-nowrap'>From last month</span>
                </p>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
    <div class='col'>
    </div>
</div>

<div class='row'>
    <div class='col-xl-6 col-lg-12 order-lg-2 order-xl-1'>
        <div class='card mx-3'>
            <div class='d-flex card-header justify-content-between align-items-center'>
                <h4 class='header-title'>Top 5 Selling Books</h4>
            </div>

            <div class='card-body pt-0'>
                <div class='table-responsive'>
                    <table class='table table-centered table-nowrap table-hover mb-0'>
                        <tbody>
                        <?php foreach (get_dash_best_sellers(5) as $book): ?>
                            <tr>
                                <td>
                                    <h5 class='font-14 my-1 fw-normal'><?= $book['Boo_Title']; ?></h5>
                                    <span class='text-muted font-13'>By <?= $book['Aut_Name']; ?></span>
                                </td>
                                <td>
                                    <h5 class='font-14 my-1 fw-normal'><?= $book['Quantity']; ?></h5>
                                    <span class='text-muted font-13'>Quantity</span>
                                </td>
                                <td>
                                    <h5 class='font-14 my-1 fw-normal'>&euro;<?= number_format($book['Amount'], 2); ?></h5>
                                    <span class='text-muted font-13'>Amount</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class='col-xl-6 col-lg-12 order-lg-2 order-xl-1'>
        <div class='card mx-3'>
            <div class='d-flex card-header justify-content-between align-items-center'>
                <h4 class='header-title'>Revenue by month</h4>
            </div>

            <div class='card-body pt-0'>
                <canvas class='p-2 w-100' id='myChart'></canvas>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row -->

<?php require_once 'includes/footer.php'; ?>

<script>
    (() => {
        'use strict'

        // Graphs
        const ctx = document.getElementById('myChart')
        // eslint-disable-next-line no-unused-vars
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php
                      foreach ($revenue_growth_all_months as $revenue_month) {
                          echo "'".$revenue_month['month']->format('Y-m-d')."', ";
                        };
                  ?>
                ],
                datasets: [{
                    data: [
                      <?php foreach ($revenue_growth_all_months as $revenue_month) {
                      echo "'".$revenue_month['total_revenue']."', ";
                    }; ?>
                    ],
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    borderWidth: 4,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        })
    })();
</script>
