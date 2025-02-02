

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Backup & Restore</h1>


</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Invoice System</a></li>
        <li class="breadcrumb-item active" aria-current="page">Backup & Restore</li>
    </ol>
</nav>



<div class="row">
    <div class="card mb-4 col-md-12">
        <div class="card-header">
            Backup
        </div>
        <div class="card-body">
            
            <p>To create a backup of the system, please click the button below</p>
            <a href="<?= BASE_URL ?>/Backup-now" target="_blank" class="btn btn-danger">Get Backup</a>
            <p>After the backup is done, store the backup file in a safe place. In case the system fails, you can restore the backup to recover the data.</p>
            
        </div>
    </div>

    <div class="card mb-4 col-md-12">
        <div class="card-header">
            Restore
        </div>
        <div class="card-body">
            
            <form action="<?= BASE_URL ?>/restore" method="POST" enctype="multipart/form-data">
                <div class="alert alert-danger" role="alert">
                    <strong>Warning!</strong> This process will erase the current data in the system.
                </div>
                <div class="form-group">
                    <label for="file">Upload Backup File</label>
                    <input type="file" class="form-control-file" id="file" name="b_file" required>
                </div>
                <button type="submit" class="btn btn-primary">Restore</button>
            </form>
            
            
        </div>
    </div>
</div>

