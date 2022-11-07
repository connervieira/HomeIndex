<?php
include "./config.php"; // Import the configuration library.



// Check to see if the user is signed in.
session_start();
if (isset($_SESSION['loggedin'])) {
	$username = $_SESSION['username'];
} else {
    $username = "";
}

if ($config["required_user"] != "") { // Check to see if a required username has been set.
    if ($username != $config["required_user"]) { // Check to see if the current user's username matches the required username.
        echo "Permissions denied"; // If not, deny the user access to this page.
        exit(); // Quit loading the rest of the page.
    }
}




// Load and initialize the database.
if (file_exists($config["database_location"]) == false) { // If the database file doesn't exist, create it.
    $item_database_file = fopen($config["database_location"], "w") or die("Unable to create database file!"); // Create the file.
    fwrite($item_database_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($item_database_file); // Close the database file.
}

if (file_exists($config["database_location"]) == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $item_database = unserialize(file_get_contents($config["database_location"])); // Load the database from the disk.
} else {
    echo "<p>The database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}




$backup_path = $_POST["path"]; // This is the file path that the database will be backed up to.
$backup_name = $_POST["name"]; // This is the file name that the database will be backed up to.

$overwrite_backup = $config["backup_overwriting"]


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
            <br><hr><br>
            <?php
            if (sizeof($sorted_items) > 0) { // Only display the search results if there are search results to begin with.
                if (sizeof($sorted_items) < $config["displayed_search_results_count"]) { // Check to see if the number of results to display is bigger than the size of the results themselves.
                    $config["displayed_search_results_count"]= sizeof($sorted_items); // Default to the maximum size of the sorted items list.
                }
                for ($x = 0; $x < $config["displayed_search_results_count"]; $x++) { // Run the loop once for every entry in the item list.
                    echo "
                    <div class='location'>
                        <h3>" . $sorted_items[$x]["name"] . "</h3>
                        <p>Difference Score: " . $sorted_items[$x]["search_score"] . "</p>
                        <p>Located in <b>" . $sorted_items[$x]["container"] . "</b> in <b>" . $sorted_items[$x]["space"] . "</b> in <b>" . $sorted_items[$x]["location"] . "</b>.</p>
                        <a class='button' href='./index.php#" . $sorted_items[$x]["location"] . " - " . $sorted_items[$x]["space"] . " - " . $sorted_items[$x]["container"] . " - " . $sorted_items[$x]["name"] . "'>Link</a><br><br>
                    </div>
                    ";
                }
            }
            ?>
        </main>
    </body>
</html>
