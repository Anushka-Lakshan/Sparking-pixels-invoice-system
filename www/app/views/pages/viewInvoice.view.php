<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />

<?php

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    include "app/models/Invoice.model.php";

    $invoice = Invoice::get_by_id($id);

    $invoice = $invoice[0];

    // show($invoice['Terms']);
}

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Invoice</h1>

    <?php



    include "app/controllers/formHandle/updateInvoice.php";
    ?>




</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?page=Invoices">Invoice</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <?= $invoice['Invoice_name'] ?></li>
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
                                <input type="text" class="form-control" readonly name="clientName" value="<?= $invoice['client_name'] ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-5">
                                Invoice Name
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="invoiceName" value="<?= $invoice['Invoice_name'] ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-5">
                                Invoice Created Date:
                            </div>
                            <div class="col-7">
                                <input type="date" class="form-control" name="openDate" value="<?= $invoice['open_date'] ?>" data-date="" data-date-format="DD MMMM YYYY" readonly>
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

                            <?php

                            $items = Json_decode($invoice['Items']);

                            $i = 1;
                            $subTotal = 0;

                            foreach ($items as $item) {

                            ?>
                                <tr>
                                    <td><input class="itemRow" type="checkbox"></td>
                                    <td><input type="text" name="item[]" id="itemName_<?= $i ?>" value="<?= $item->name ?>" autocomplete="off" class="form-control"></td>
                                    <td>
                                        <textarea name="description[]" id="" cols="30" rows="4" class="form-control"><?= $item->description ?></textarea>
                                    </td>
                                    <td><input type="number" name="unitCost[]" id="itemUnitCost_<?= $i ?>" value="<?= $item->unitCost ?>" autocomplete="off" class="form-control"></td>
                                    <td><input type="number" name="quantity[]" id="itemQuantity_<?= $i ?>" value="<?= $item->quantity ?>" autocomplete="off" class="form-control" min="1"></td>
                                    <td><input type="text" name="" id="itemTotal_<?= $i ?>" autocomplete="off" class="form-control" readonly value="<?= $item->unitCost * $item->quantity ?>"></td>
                                </tr>
                            <?php
                                $i++;
                                $subTotal += $item->unitCost * $item->quantity;
                            }
                            ?>




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
                                    <input type="text" class="form-control" id="subTotal" readonly value="<?= $subTotal ?>">
                                </div>
                            </div>

                        </div>
                    </div>


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
                            <?php
                            $payments = Json_decode($invoice['payments']);

                            $i = 1;
                            $totalPayment = 0;

                            foreach ($payments as $payment) {

                                $totalPayment += $payment->amount;
                            ?>
                                <tr>
                                    <td><input class="paymentRow" type="checkbox"></td>
                                    <td><input type="text" name="paymentName[]" id="paymentName_<?= $i ?>" autocomplete="on" class="form-control" value="<?= $payment->name ?>"></td>
                                    <td><input type="date" class="form-control" name="paymentDate[]" id="paymentDate_1" value="<?= $payment->date ?>" data-date="" data-date-format="DD MMMM YYYY"></td>
                                    <td><input type="number" name="paymentAmount[]" id="paymentAmount_1" autocomplete="off" class="form-control" value="<?= $payment->amount ?>"></td>
                                </tr>


                            <?php
                                $i++;
                            }
                            ?>
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
                                    <input type="text" class="form-control" id="Totalpayments" readonly value="<?= $totalPayment ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p class="text-right"><b>Discount(LKR)</b></p>
                                </div>
                                <div class="col-8">
                                    <input type="number" name="discount" id="discount" class="form-control" value="<?= $invoice['discount'] ?>">
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
                                    <input type="text" class="form-control" name="balance" id="balance" readonly value="<?= $invoice['balance'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="submitType" id="submitButton" value="">
                    <div class="d-flex justify-content-end mt-4 mb-4 w-100 ">
                        <button class="btn btn-primary mr-2" type="submit" name="save-invoice" value="save">Update Invoice</button>
                        <button class="btn btn-success mr-2" type="submit" name="print-invoice" value="print">Update And Download Invoice</button>
                        <button class="btn btn-danger" type="button" id="delete-invoice" onclick="deleteInvoice(<?= $invoice['id'] ?>)">Delete Invoice</button>
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
                    <textarea name="terms" id="editor1" class="form-control ckEditor" cols="30" rows="10"><?= $invoice['Terms'] ?></textarea>
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
                    <textarea name="notes" id="editor2" class="form-control ckEditor" cols="30" rows="10"><?= $invoice['notes'] ?></textarea>
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



    function deleteInvoice(id) {
        Swal.fire({
            title: "Are you sure? You want to delete this Invoice?",
            text: "You won't be able to revert this!, proceed with caution!!! ",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff6347",
            cancelButtonColor: "#48c28d",
            confirmButtonText: "Yes, delete !",
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform actions with the form data, e.g., make an AJAX request
                window.location = "<?= BASE_URL ?>?page=deleteInvoice&id=" + id;
            }
        });
    }
</script>


<script src="<?= BASE_URL ?>/assets/js/handleInvoice.js"></script>