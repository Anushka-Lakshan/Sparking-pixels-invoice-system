<?php

// Function to restore SQLite database from backup file
function restoreBackup($backupFile, $destinationFile)
{
    // Copy backup file to destination directory
    if (copy($backupFile, $destinationFile)) {
        return true;
    } else {
        return false;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded
    if (isset($_FILES['b_file']) && $_FILES['b_file']['error'] === UPLOAD_ERR_OK) {
        // Destination directory for restored database
        $destinationFile = 'app/core/Database.db';

        // Move uploaded file to destination
        if (move_uploaded_file($_FILES['b_file']['tmp_name'], $destinationFile)) {
            echo "Database restored successfully.";
        } else {
            echo "Failed to restore database.";
        }
    } else {
        echo "Upload error: " . $_FILES['b_file']['error'];
    }
}



echo '<br><br><br><a href="'.BASE_URL.'">Back</a>';



