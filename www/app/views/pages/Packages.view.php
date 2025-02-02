<!-- Page Heading -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Packages</h1>
    <a href="<?= BASE_URL ?>?page=addPackage" class="d-inline-block btn btn-md btn-primary shadow-md"><i class="fas fa-plus fa-lg text-white-50"></i> New Package</a>

</div>

<div class="row">
    <?php

    include "app/models/Packages.model.php";



    $tableData = Packages::get_all();

    ?>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">All Packages</h5>
                <div class="table-responsive">
                    <table id="DataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="30%">Item</th>
                                <th width="50%">Description</th>
                                <th width="10%">Unit Cost</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($tableData as $key => $value) {
                                echo "<tr>";
                                echo "<td>" . $value['id'] . "</td>";
                                echo "<td>" . $value['Item'] . "</td>";
                                echo "<td><p>" . $value['Description'] . "</p></td>";
                                echo "<td>" . $value['UnitCost'] . " LKR </td>";

                                echo "<td>
                                    <a class='btn btn-primary' href='?page=viewPackage&id=" . $value['id'] . "'>Select</a>
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