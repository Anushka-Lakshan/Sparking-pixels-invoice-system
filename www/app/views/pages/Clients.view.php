<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Clients</h1>
    <a href="<?= BASE_URL ?>?page=addClient" class="d-inline-block btn btn-md btn-primary shadow-md"><i class="fas fa-plus fa-lg text-white-50"></i> New Client</a>

</div>

<div class="row">
    <?php

    include "app/models/Client.model.php";

    $client = new Client();

    $tableData = $client::get_all();

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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>NIC</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($tableData as $key => $value) {
                                echo "<tr>";
                                echo "<td>" . $value['id'] . "</td>";
                                echo "<td>" . $value['Name'] . "</td>";
                                echo "<td>" . $value['Phone'] . "</td>";
                                echo "<td>" . $value['Email'] . "</td>";
                                echo "<td>" . $value['Address'] . "</td>";
                                echo "<td>" . $value['NIC'] . "</td>";
                                echo "<td>
                                    <a class='btn btn-primary' href='?page=viewClient&id=" . $value['id'] . "'>Select</a>
                                    <a class='btn btn-success' href='?page=newInvoice&C_id=" . $value['id'] . "'>New Invoice</a>
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