<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.



// Process any GET information submitted.

// Collect any information from the form that may have been submitted.
$location = $_GET["location"]; // This is the location the item is in.
$space = $_GET["space"]; // This is the space the item is in.
$container = $_GET["container"]; // This is the container the item is in.
$item = $_GET["item"]; // This is the name of the item.
$confirm = $_GET["confirm"]; // This is the deletion confirmation.


if ($confirm == "true") {
    unset($item_database[$username]["locations"][$location]["spaces"][$space]["containers"][$container]["items"][$item]); // Remove the item from the database.

    if (sizeof($item_database[$username]["locations"][$location]["spaces"][$space]["containers"][$container]["items"]) == 0) { // Check to see if this container is now empty.
        unset($item_database[$username]["locations"][$location]["spaces"][$space]["containers"][$container]); // Remove the empty container.
    }
    if (sizeof($item_database[$username]["locations"][$location]["spaces"][$space]["containers"]) == 0) { // Check to see if this space is now empty.
        unset($item_database[$username]["locations"][$location]["spaces"][$space]); // Remove the empty space.
    }
    if (sizeof($item_database[$username]["locations"][$location]["spaces"]) == 0) { // Check to see if this location is now empty.
        unset($item_database[$username]["locations"][$location]); // Remove the empty location.
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
