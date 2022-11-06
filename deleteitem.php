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



// Process any GET information submitted.

// Collect any information from the form that may have been submitted.
$location = $_GET["location"]; // This is the location the item is in.
$space = $_GET["space"]; // This is the space the item is in.
$container = $_GET["container"]; // This is the container the item is in.
$item = $_GET["item"]; // This is the name of the item.
$confirm = $_GET["confirm"]; // This is the deletion confirmation.


if ($confirm == "true") {
    unset($item_database["locations"][$location]["spaces"][$space]["containers"][$container]["items"][$item]); // Remove the item from the database.

    if (sizeof($item_database["locations"][$location]["spaces"][$space]["containers"][$container]["items"]) == 0) { // Check to see if this container is now empty.
        unset($item_database["locations"][$location]["spaces"][$space]["containers"][$container]); // Remove the empty container.
    }
    if (sizeof($item_database["locations"][$location]["spaces"][$space]["containers"]) == 0) { // Check to see if this space is now empty.
        unset($item_database["locations"][$location]["spaces"][$space]); // Remove the empty space.
    }
    if (sizeof($item_database["locations"][$location]["spaces"]) == 0) { // Check to see if this location is now empty.
        unset($item_database["locations"][$location]); // Remove the empty location.
    }

    file_put_contents($config["database_location"], serialize($item_database)); // Write database changes to disk.
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Index</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <main>
            <?php
                if ($confirm == "true") {
                    echo "<p>Item deleted</h3>";
                    echo "<a class='button' href='./index.php'>Back</a>";
                } else {
                    echo "<p>Are you sure you want to delete this item?</h3>";
                    echo "<a class='button' href='./deleteitem.php?confirm=true&location=" . $location . "&space=" . $space . "&container=" . $container . "&item=" . $item . "'>Confirm</a>";
                    echo "<a class='button' href='./index.php'>Cancel</a>";
                }
            ?>
        </main>
    </body>
</html>
