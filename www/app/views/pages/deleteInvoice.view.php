<?php
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    include "app/models/Invoice.model.php";

    $data = Invoice::deleteInvoice($id);

    if ($data) {
        sweetAlert("Invoice Deleted!", "");
        // header("Location: " . BASE_URL . "?page=clients");
        echo "<script>window.location.href = '" . BASE_URL . "?page=Invoices';</script>";
    } else {
        sweetAlert("Something went wrong!", "error");
        // header("Location: " . BASE_URL . "?page=viewClient&id=" . $id);
        echo "<script>window.location.href = '" . BASE_URL . "?page=viewInvoice&id=" . $id . "';</script>";
    }
} else {
    // header("Location: " . BASE_URL . "?page=clients");
    echo "<script>window.location.href = '" . BASE_URL . "?page=Invoices';</script>";
}
