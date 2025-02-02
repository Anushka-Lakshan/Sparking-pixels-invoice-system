<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    $items = [];
    $payments = [];

    // Format items data
    for ($i = 0; $i < count($_POST['item']); $i++) {
        $items[] = [
            'name' => $_POST['item'][$i],
            'description' => $_POST['description'][$i],
            'unitCost' => $_POST['unitCost'][$i],
            'quantity' => $_POST['quantity'][$i]
        ];
    }

    // Format payments data
    for ($i = 0; $i < count($_POST['paymentName']); $i++) {

        if (empty($_POST['paymentName'][$i])) {
            continue;
        }
        $payments[] = [
            'name' => $_POST['paymentName'][$i],
            'date' => $_POST['paymentDate'][$i],
            'amount' => $_POST['paymentAmount'][$i]
        ];
    }
    $invoice_name = $_POST['invoiceName'];
    $open_date = $_POST['openDate'];
    $discount = $_POST['discount'];
    $balance = $_POST['balance'];
    $notes = $_POST['notes'];
    $terms = $_POST['terms'];
    $last_edit_date = $_POST['openDate'];
    $client_id = $_GET['C_id'];
    $client_name = $_POST['clientName'];
    $jsonItems = json_encode($items);
    $jsonPayments = json_encode($payments);

    include_once "app/models/Invoice.model.php";
    $invoice = new Invoice();

    $id = $invoice::add_invoice($client_id, $client_name, $invoice_name, $open_date, $last_edit_date, $jsonItems, $jsonPayments, $discount, $balance, $notes, $terms);

    if ($id > 0) {

        if(isset($_POST['submitType']) && $_POST['submitType'] == 'print') {
            echo '</div><div width="100%" class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Invoice PDF Generating ...  Please wait..</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
            echo "<script>window.location.href = '" . BASE_URL . "/invoice?id=" . $id . "';</script>";
        }
        sweetAlert("Invoice Added!", "success");
        echo "<script>window.location.href = '" . BASE_URL . "?page=viewInvoice&id=" . $id . "';</script>";
    }
}
