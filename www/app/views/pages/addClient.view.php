<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Client</h1>


</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?page=Clients">Clients</a></li>
        <li class="breadcrumb-item active" aria-current="page">New Client</li>
    </ol>
</nav>


<?php
if (isset($_POST['add-client'])) {

    $data = array(
        'name' => $_POST['name'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'nic' => $_POST['nic']
    );

    include "app/models/Client.model.php";

    $client = new Client();

    $errors = $client::add_client($data);

    if ($errors === array('success' => true)) {

        echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Member Added Successfully
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <script>
                                    window.location = "' . BASE_URL . '?page=Clients";
                                </script>
                            ';

        unset($_POST);
    } else if (is_array($errors) && count($errors) > 0) {
        echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ';
        foreach ($errors as $error) {

            echo $error . "<br>";
        }
        echo '
                                <button type="button" class="btn-close btn" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
    }
}
?>

<div class="row">
    <div class="card mb-4 col-md-6">
        <div class="card-header">
            Enter Client Details
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required autocomplete="off" <?= isset($_POST['name']) ? 'value="' . $_POST['name'] . '"' : '' ?>>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" <?= isset($_POST['phone']) ? 'value="' . $_POST['phone'] . '"' : '' ?>>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="false" <?= isset($_POST['email']) ? 'value="' . $_POST['email'] . '"' : '' ?>>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="3"><?= isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>
                </div>
                <div class="form-group">
                    <label for="nic">NIC:</label>
                    <span class="text-muted small mt-2">Optional</span>
                    <input type="text" class="form-control" id="nic" name="nic" autocomplete="off" <?= isset($_POST['nic']) ? 'value="' . $_POST['nic'] . '"' : '' ?>>

                </div>
                <button type="submit" name="add-client" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>