<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Settings</h1>


</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Settings</a></li>
    </ol>
</nav>


<?php
include_once "app/models/Setting.model.php";

$setting = Setting::get_setting();



if (isset($_POST['update'])) {


    $result = Setting::edit_setting($_POST['terms'], $_POST['address'], $_POST['phone'], $_POST['email']);

    if ($result) {

        sweetAlert('Good job!', 'Settings Updated Successfully', 'success');

        echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Settings Updated Successfully
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <script> window.location = "' . BASE_URL . '" </script>
                            ';

        unset($_POST);
    } else {
        echo '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> Something went wrong
                            ';

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
            Change Settings
        </div>
        <div class="card-body">
            <form action="" method="POST">

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="false" <?= isset($_POST['email']) ? 'value="' . $_POST['email'] . '"' : 'value="' . $setting['Email'] . '"' ?>>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="3"><?= isset($_POST['address']) ? $_POST['address'] : $setting['Address'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" autocomplete="false" <?= isset($_POST['phone']) ? 'value="' . $_POST['phone'] . '"' : 'value="' . $setting['Tel'] . '"' ?>>
                </div>
                <div class="form-group">
                    <label for="terms">Terms</label>
                    <textarea name="terms" id="terms" class="form-control ckEditor" cols="30" rows="10"><?= isset($_POST['terms']) ? $_POST['terms'] : $setting['Terms'] ?></textarea>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#terms'))
        .catch(error => {
            console.error(error);
        });
</script>