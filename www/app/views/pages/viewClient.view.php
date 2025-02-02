<?php
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    include "app/models/Client.model.php";

    $client_ins = new Client();

    $data = $client_ins::get_by_id($id);

    $client = $data[0];

    include "app/models/Invoice.model.php";

    $invoices = Invoice::get_by_client_id($id);

    
}


?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Client Details</h1>


</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?page=Clients">Clients</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $client['Name'] ?></li>
    </ol>
</nav>


<?php
if (isset($_POST['edit-client'])) {

    $data = array(
        'name' => $_POST['name'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'nic' => $_POST['nic'],
        'id' => $_GET['id']
    );


    $errors = $client_ins::update_client($data);

    if ($errors === array('success' => true)) {

        unset($_POST);



        $data = $client_ins::get_by_id($id);

        $client = $data[0];

        echo '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Client Details Updated Successfully
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
                                </div>

                                <script>location.href = "' . BASE_URL . '?page=viewClient&id=' . $client['id'] . '" </script>
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
                    <input type="text" class="form-control" id="name" name="name" required autocomplete="off" <?= isset($_POST['name']) ? 'value="' . $_POST['name'] . '"' : 'value="' . $client['Name'] . '"' ?>>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" <?= isset($_POST['phone']) ? 'value="' . $_POST['phone'] . '"' : 'value="' . $client['Phone'] . '"' ?>>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="false" <?= isset($_POST['email']) ? 'value="' . $_POST['email'] . '"' : 'value="' . $client['Email'] . '"' ?>>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="3"><?= isset($_POST['address']) ? $_POST['address'] : $client['Address'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="nic">NIC:</label>
                    <span class="text-muted small mt-2">Optional</span>
                    <input type="text" class="form-control" id="nic" name="nic" autocomplete="off" <?= isset($_POST['nic']) ? 'value="' . $_POST['nic'] . '"' : 'value="' . $client['NIC'] . '"' ?>>
                </div>
                <button type="submit" name="edit-client" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-danger" onclick="deleteClient(<?= $client['id'] ?>)">Delete</button>
                <button type="button" class="btn btn-info" onclick="window.location='<?= BASE_URL ?>?page=newInvoice&C_id=<?= $client['id'] ?>'">New Invoice</button>

            </form>

        </div>
    </div>
    <div class="card mb-4 col-md-6">
        <div class="card-header">
            Invoices
        </div>
        <div class="card-body">
            <?php            

            if (empty($invoices)) {
                echo "No Invoices made yet, <a href='<?= BASE_URL ?>?page=newInvoice&C_id=".$id."'>click here</a> to create one now";
            }
            else{ ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoices as $invoice) { ?>
                        <tr>
                            <td><?= $invoice['id'] ?></td>
                            <td><?= $invoice['Invoice_name'] ?></td>
                            <td><?= $invoice['balance'] ?></td>
                            <td><a href="<?= BASE_URL ?>?page=viewInvoice&id=<?= $invoice['id'] ?>" class="btn btn-primary">View</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            

                <?php
            }
            ?>
        </div>
    </div>
</div>


<script>
    function deleteClient(id) {
        Swal.fire({
            title: 'Are you sure? You want to delete this Client?',
            text: "You won't be able to revert this!, proceed with caution!!! ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6347',
            cancelButtonColor: '#48c28d',
            confirmButtonText: 'Yes, delete !'

        }).then((result) => {
            if (result.isConfirmed) {
                // Perform actions with the form data, e.g., make an AJAX request
                window.location = "<?= BASE_URL ?>?page=deleteClient&id=" + id;
            }
        })
    }
</script>