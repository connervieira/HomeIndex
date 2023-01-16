<?php
include "./config.php"; // Import the configuration library.
$admin_only = true;
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.



$backup_path = $_POST["path"]; // This is the file path that the database will be backed up to.
$backup_name = $_POST["name"]; // This is the file name that the database will be backed up to.

$overwrite_backup = $config["backup_overwriting"]; // This variable determines whether the tool is permitted to overwrite existing files.


if ($backup_path !== "" and $backup_path !== null) { // Only run backup processing if the user has entered a backup path.
    if (file_exists($backup_path) == true) {
        if ($backup_name !== "" and $backup_name !== null) { // Check to make sure the user entered a file name for the backup.
            if (file_exists($backup_path . "/" . $backup_name) == false or $overwrite_backup == true) { // Check to see if the specified backup location already has an existing file, or if backup overwriting is enabled.
                if (is_writable($backup_path) == true) { // Check to make sure the backup directory is writable.
                    file_put_contents($backup_path . "/" . $backup_name, serialize($item_database)); // Write the database to the backup location.
                    echo "<p>Successfully backed up item database.</p>";
                } else {
                    echo "<p>The indicated backup path is not writable.</p>";
                }
            } else {
                echo "<p>The specified backup file already exists, and backup overwriting is disabled.</p>";
            }
        } else {
            echo "<p>No backup file name was entered.</p>";
        }
    } else {
        echo "<p>The specified backup directory does not exist.</p>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Database Backup</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <main>
            <div class="button-container">
                <a class="button" href="./tools.php">Back</a>
            </div>
            <h1>Database Backup</h1>
            <hr>
            <div class="new-item">
                <form method="POST">
                    <label for="path">Backup Directory: </label><input type="text" name="path" id="path" placeholder="Backup Path" required><br>
                    <label for="name">Backup File Name: </label><input type="text" name="name" id="name" placeholder="Backup Name" required><br>
                    <br>
                    <input class="button" type="submit" value="Submit">
                </form>
            </div>
        </main>
    </body>
</html>
