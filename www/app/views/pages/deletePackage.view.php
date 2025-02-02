<?php
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    include "app/models/Packages.model.php";

    $data = Packages::delete_package($id);

    if ($data) {
        sweetAlert("Package Deleted!", "");
        // header("Location: " . BASE_URL . "?page=clients");
        echo "<script>window.location.href = '" . BASE_URL . "?page=Packages';</script>";
    } else {
        sweetAlert("Something went wrong!", "error");
        // header("Location: " . BASE_URL . "?page=viewClient&id=" . $id);
        echo "<script>window.location.href = '" . BASE_URL . "?page=viewPackage&id=" . $id . "';</script>";
    }
} else {
    // header("Location: " . BASE_URL . "?page=clients");
    echo "<script>window.location.href = '" . BASE_URL . "?page=Packages';</script>";
}