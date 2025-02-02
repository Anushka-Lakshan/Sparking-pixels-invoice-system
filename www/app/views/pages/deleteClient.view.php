<?php
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    include "app/models/Client.model.php";

    $client_ins = new Client();

    $data = $client_ins::deleteClient($id);

    if ($data) {
        sweetAlert("Client Deleted!", "");
        // header("Location: " . BASE_URL . "?page=clients");
        echo "<script>window.location.href = '" . BASE_URL . "?page=clients';</script>";
    } else {
        sweetAlert("Something went wrong!", "error");
        // header("Location: " . BASE_URL . "?page=viewClient&id=" . $id);
        echo "<script>window.location.href = '" . BASE_URL . "?page=viewClient&id=" . $id . "';</script>";
    }
} else {
    // header("Location: " . BASE_URL . "?page=clients");
    echo "<script>window.location.href = '" . BASE_URL . "?page=clients';</script>";
}
