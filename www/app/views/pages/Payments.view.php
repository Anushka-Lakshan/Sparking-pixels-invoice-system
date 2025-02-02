<!-- Page Heading -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Recent Payments</h1>

</div>

<div class="row">
    <?php

    include "app/models/Dashboard.model.php";



    $tableData = Dashboard::getPayments();

    ?>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Payments</h5>
                <div class="table-responsive">
                    <table id="DataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="10%">Invoice Id</th>
                                <th width="25%">Client</th>
                                <th width="25%">Invoice Name</th>
                                <th width="20%">Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($tableData as $key => $value) {
                                echo "<tr>";
                                $date = date_create($value['payment_date']);
                                echo "<td>" . date_format($date, 'd M Y') . "</td>";
                                echo "<td> <a href='" . BASE_URL . "?page=viewInvoice&id=" . $value['id'] . "'>SP " . $value['id'] . "</a></td>";
                                echo "<td><a href='". BASE_URL ."?page=viewClient&id=" . $value['client_id'] . "'>" . $value['Name'] . "</a></td>";
                                echo "<td>" . $value['Invoice_name'] . "</td>";
                                echo "<td>" . $value['amount'] . " LKR </td>";

                                
                            }
                            ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>





        <!--              End-->

    </div>
</div>