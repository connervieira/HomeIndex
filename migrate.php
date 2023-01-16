<?php
// This is a tool used to migrate the original Home Index database system, to the new user-based system.

// Originally, Home Index only supported a single user, and the item database held information about a single inventory.
// Now that Home Index supports multiple users, each user's item inventory database is stored in a separate sub-database.
// This tool takes the original item database, and assigns it to a user so it can be migrated to newer version of Home Index.

// Follow these instructions to use this tool.
// 1. Take your Home Index instance offline so that it can't be accessed exterally.
// 2. Sign in with the user you want to migrate the existing item databse to.
// 3. Enable this tool by changing the 'active' variable below.
// 4. Load this script in a the browser that you've signed in with.
// 5. Allow the migration process to complete.
$active = false;











if ($active == false) {
    echo "<p>This script has not been activated.</p>";
    exit();
}

include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.


// Initialize the database.
if (file_exists($config["database_location"]) == false) { // If the database file doesn't exist, create it.
    $item_database_file = fopen($config["database_location"], "w") or die("Unable to create database file!"); // Create the file.
    fwrite($item_database_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($item_database_file); // Close the database file.
    if (!isset($item_database[$username])) { // Check to see if the user already exists in the item database.
        $item_database[$username] = array();
    }
}



// Load the database.
if (file_exists($config["database_location"]) == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $item_database = unserialize(file_get_contents($config["database_location"])); // Load the database from the disk.
} else {
    echo "<p>The database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}


if (isset($item_database["locations"])) {
    $migrated_item_database[$username] = $item_database;
    file_put_contents($config["database_location"], serialize($migrated_item_database)); // Write database changes to disk.
    echo "<p>The database has been migrated to the user " . $username . ".</p>";
} else {
    echo "<p>The database appears to have already been migrated!</p>";
}
?>
