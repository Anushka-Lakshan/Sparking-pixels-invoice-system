<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Package</h1>


</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?page=Packages">Packages</a></li>
        <li class="breadcrumb-item active" aria-current="page">New Package</li>
    </ol>
</nav>


<?php
if (isset($_POST['add-package'])) {

    // $data = array(
    //     'name' => $_POST['name'],
    //     'description' => $_POST['description'],
    //     'cost' => $_POST['cost']
    // );

    include "app/models/Packages.model.php";

    $result = Packages::add_package($_POST['name'], $_POST['description'], $_POST['cost']);

    if ($result === true) {

        echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Package Added Successfully
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <script>
                                    window.location = "' . BASE_URL . '?page=Packages";
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
    } else {
        echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> Something went wrong
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
    }
}
?>

<div class="row">
    <div class="card mb-4 col-md-6">
        <div class="card-header">
            Enter Package Details
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Item Name</label>
                    <input type="text" class="form-control" id="name" name="name" required autocomplete="off" <?= isset($_POST['name']) ? 'value="' . $_POST['name'] . '"' : '' ?>>
                </div>

                <div class="form-group">
                    <label for="address">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="6" required><?= isset($_POST['description']) ? $_POST['description'] : '' ?></textarea>
                </div>
                <!-- <div class="form-group">
                    <label for="email">UnitCost</label>
                    <input type="number" class="form-control" id="cost" name="cost" autocomplete="false" <?= isset($_POST['cost']) ? 'value="' . $_POST['cost'] . '"' : '' ?>>
                </div> -->
                <div class="input-group mb-3">
                    <input type="number" class="form-control" placeholder="Unit Cost" name="cost" autocomplete="false" <?= isset($_POST['cost']) ? 'value="' . $_POST['cost'] . '"' : '' ?>>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">LKR</span>
                    </div>
                </div>
                <button type="submit" name="add-package" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>