<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    // die();

    $id = $_GET['id'];

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
    if (isset($_POST['paymentName'])) {
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
    }
    $invoice_name = $_POST['invoiceName'];
    $discount = $_POST['discount'];
    $balance = $_POST['balance'];
    $notes = $_POST['notes'];
    $terms = $_POST['terms'];
    $jsonItems = json_encode($items);
    $jsonPayments = json_encode($payments);

    include_once "app/models/Invoice.model.php";
    $invoice = new Invoice();

    $result = $invoice::update_invoice($id, $invoice_name, $jsonItems, $jsonPayments, $discount, $balance, $notes, $terms);

    if ($result) {

        if (isset($_POST['submitType']) && $_POST['submitType'] == 'print') {

            echo '</div><div width="100%" class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Invoice PDF Generating ...  Please wait..</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';

            echo "<script>window.location.href = '" . BASE_URL . "/invoice?id=" . $id . "';</script>";
        }

        sweetAlert("Invoice Updated!", "");
        echo "<script>window.location.href = '" . BASE_URL . "?page=viewInvoice&id=" . $id . "';</script>";
    } else {
        sweetAlert("Something went wrong!", "error");
        echo "<script>window.location.href = '" . BASE_URL . "?page=viewInvoice&id=" . $id . "';</script>";
    }
}
