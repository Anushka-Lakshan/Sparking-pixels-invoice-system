<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">New Invoice</h1>

    <?php
    include_once "app/models/Client.model.php";
    include_once "app/models/Setting.model.php";

    $terms = Setting::get_setting();

    $terms = $terms['Terms'];

    $client = new Client();

    $clientName = $client::get_by_id($_GET['C_id']);

    $clientName = $clientName[0]['Name'];


    include "app/controllers/formHandle/newInvoice.php";
    ?>




</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?page=Invoices">Invoice</a></li>
        <li class="breadcrumb-item active" aria-current="page">New Invoice</li>
    </ol>
</nav>
<div class="container-fluid">

    <form action="" method="POST" enctype="multipart/form-data" id="newInvoice">
        <div class="row">
            <div class="col-md-6">
                <!-- invoice details -->
                <div class="card mb-4">
                    <div class="card-header">
                        Invoice Details
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-5">
                                Client name
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" readonly name="clientName" value="<?= $clientName ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-5">
                                Invoice Name
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="invoiceName" required value="<?= $clientName ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-5">
                                Invoice Open Date:
                            </div>
                            <div class="col-7">
                                <input type="date" class="form-control" name="openDate" value="<?= date('Y-m-d') ?>" data-date="" data-date-format="DD MMMM YYYY">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end invoice details -->
            </div>
        </div>

        <div class="row mb-4">
            <div class="card w-100">
                <div class="card-header">
                    Invoice Items
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th width="2%"></th>
                                <th width="20%">Item</th>
                                <th width="38%">Description</th>
                                <th width="10%">Unit Cost</th>
                                <th width="10%">Quantity</th>
                                <th width="20%">Line Total</th>
                            </tr>
                        </thead>
                        <tbody id="itemTable">
                            <tr class="">
                                <td><input class="itemRow" type="checkbox"></td>
                                <td><input type="text" name="item[]" id="itemName_1" autocomplete="off" class="form-control"></td>
                                <td>

                                    <textarea name="description[]" id="" cols="30" rows="2" class="form-control"></textarea>
                                </td>
                                <td><input type="number" name="unitCost[]" id="itemUnitCost_1" autocomplete="off" class="form-control" value="0"></td>
                                <td><input type="number" name="quantity[]" id="itemQuantity_1" autocomplete="off" class="form-control" min="1" value="1"></td>
                                <td><input type="text" name="" id="itemTotal_1" autocomplete="off" class="form-control" readonly></td>
                            </tr>
                    </table>
                    <div class="row">
                        <div class="col-5">
                            <button class="btn btn-danger mr-2" type="button" id="remove-row">- Delete</button>
                            <button class="btn btn-success mr-2" type="button" id="add-row">+ Add Item</button>
                            <button class="btn btn-info " type="button" id="add-package">+ Add Package</button>
                        </div>
                        <div class="col-4 ml-auto">
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-right "><b>Subtotal</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="subTotal" readonly>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-4">
                                    <p class="text-right"><b>Discount(LKR)</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="number" name="discount" id="discount" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-right "><b>Paid to Date(LKR)</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control" id="paid" name="paid">
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- <hr>
                    <div class="row mb-6">
                        <div class="col-4 ml-auto">
                            <div class="row mb-6">
                                <div class="col-4">
                                    <p class="text-right "><b>Balance Due (LKR)</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="balance" id="balance" readonly>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="d-flex justify-content-end mt-4 mb-4 w-100 ">
                        <button class="btn btn-primary mr-2" type="submit" name="save-invoice">Save Invoice</button>
                        <button class="btn btn-success" type="submit" name="print-invoice">Save And Print Invoice</button>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- payments -->
        <div class="row mb-4">

            <div class="card w-100">
                <div class="card-header">
                    Payments
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th width="3%"></th>
                                <th width="37%">Name</th>
                                <th width="30%">Date</th>
                                <th width="30%">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTable">
                            <tr>
                                <td><input class="paymentRow" type="checkbox"></td>
                                <td><input type="text" name="paymentName[]" id="paymentName_1" autocomplete="on" class="form-control"></td>
                                <td><input type="date" class="form-control" name="paymentDate[]" id="paymentDate_1" value="<?= date('Y-m-d') ?>" data-date="" data-date-format="DD MMMM YYYY"></td>
                                <td><input type="number" name="paymentAmount[]" id="paymentAmount_1" autocomplete="off" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-5">
                            <button class="btn btn-danger mr-2" type="button" id="remove-payment">- Delete Payment</button>
                            <button class="btn btn-success mr-2" type="button" id="add-payment">+ Add Payment</button>

                        </div>
                        <div class="col-4 ml-auto">
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-right "><b>Total Payments</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="Totalpayments" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-right"><b>Discount(LKR)</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="number" name="discount" id="discount" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row mb-6">
                        <div class="col-4 ml-auto">
                            <div class="row mb-6">
                                <div class="col-4">
                                    <p class="text-right "><b>Balance Due (LKR)</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="balance" id="balance" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="submitType" id="submitButton" value="">
                    <div class="d-flex justify-content-end mt-4 mb-4 w-100 ">
                        <button class="btn btn-primary mr-2" type="submit" name="save-invoice" value="save">Save Invoice</button>
                        <button class="btn btn-success" type="submit" name="print-invoice" value="print">Save And Download Invoice</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card w-100 pb-5 mb-3">
                <div class="card-header">
                    Terms
                </div>
                <div class="card-body">
                    <textarea name="terms" id="editor1" class="form-control ckEditor" cols="30" rows="10"> <?= $terms ?> </textarea>
                    <!-- <div name="terms" id="Terms" class="form-control">
                        
                    </div> -->
                </div>

            </div>
        </div>

        <div class="row">
            <div class="card w-100 pb-5">
                <div class="card-header">
                    Additional Notes
                </div>
                <div class="card-body">
                    <textarea name="notes" id="editor2" class="form-control ckEditor" cols="30" rows="10"></textarea>
                    <!-- <div name="notes" id="notes" class="form-control">
                        
                    </div> -->
                </div>

            </div>
        </div>
    </form>

</div>

<style>
    textarea {
        resize: none;
    }
</style>

<?php
include_once "app/models/Packages.model.php";

$packages = Packages::get_all();

$packages = json_encode($packages);
?>

<!-- Initialize Quill editor -->
<script>
    var packages = <?= $packages ?>;

    ClassicEditor
        .create(document.querySelector('#editor1'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor2'))
        .catch(error => {
            console.error(error);
        });
</script>


<script src="<?= BASE_URL ?>/assets/js/handleInvoice.js"></script>