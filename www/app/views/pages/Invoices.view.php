<?php
include "app/models/Client.model.php";

$clients = Client::get_all();

$data = "<table id='DataTable' class='table table-bordered table-striped' style='display: block; max-height: 600px; overflow-y: scroll'>
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr> </thead> <tbody>";

foreach ($clients as $client) {
    $data .= "<tr><td>" . $client['Name'] . "</td><td>" . $client['Phone'] . "</td><td style='width: 100px'><a class='btn btn-primary' href='" . BASE_URL . "?page=newInvoice&C_id=" . $client['id'] . "'>Select</a></td></tr>";
}

$data .= "</tbody>  </table>";

?>



<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Invoices</h1>
    <button onclick="newInvoice()" class="d-md-inline-block btn btn-md btn-primary shadow-md"><i class="fas fa-plus fa-lg text-white-50"></i> New Invoice</button>

</div>

<div class="row">

    <?php

    include "app/models/Invoice.model.php";



    $tableData = Invoice::get_all();

    ?>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Customers</h5>
                <div class="table-responsive">
                    <table id="DataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client name</th>
                                <th>Invoice name</th>
                                <th>Created</th>
                                <th>Last Edit</th>
                                <th>Balance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($tableData as $key => $value) {
                                echo "<tr>";
                                echo "<td>" . $value['id'] . "</td>";
                                echo "<td>" . $value['client_name'] . "</td>";
                                echo "<td>" . $value['Invoice_name'] . "</td>";
                                echo "<td>" . $value['open_date'] . "</td>";
                                echo "<td>" . $value['last_edit_date'] . "</td>";
                                echo "<td>" . $value['balance'] . " LKR </td>";
                                echo "<td>
                                    <a class='btn btn-primary' href='?page=viewInvoice&id=" . $value['id'] . "'>Select</a>
                                    
                                  </td>";
                                echo "</tr>";
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


<script>
    var data = `<?php echo $data; ?>`;

    function newInvoice() {
        Swal.fire({
            title: 'Select Client',
            html: data,
            confirmButtonText: 'Close'
        });
    }
</script>