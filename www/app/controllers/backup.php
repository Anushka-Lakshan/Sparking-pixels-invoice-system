<?php

// Function to create a backup of SQLite database
function createBackup($sourceFile, $destinationDir)
{
    // Generate filename with timestamp
    $backupFilename = 'backup_' . date('Y-m-d_H-i-s') . '.db';

    // Copy SQLite database file to destination directory
    if (copy($sourceFile, $destinationDir . $backupFilename)) {
        return $destinationDir . $backupFilename;
    } else {
        return false;
    }
}

// SQLite database file path
$sourceFile = 'app/core/Database.db';

// Destination directory for backup files
$destinationDir = 'backup-files/out';

// Trigger backup creation
$backupFilePath = createBackup($sourceFile, $destinationDir);

if ($backupFilePath) {
    // Send file to user for download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($backupFilePath) . '"');
    header('Content-Length: ' . filesize($backupFilePath));
    readfile($backupFilePath);
    exit;
} else {
    echo "Failed to create backup.";
}
