<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.



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
?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - List Items</title>
    </head>

    <body>
        <main>
            <ul>
                <?php
                if (sizeof($item_database) > 0) { // Only display the information in the item database there is actually information to show.
                    foreach ($item_database[$username]["locations"] as $location_name => $location_information) {
                        echo "<li>" . $location_name . "</li>";
                        echo "<ul>";
                        foreach ($item_database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) {
                            echo "<li>" . $space_name . "</li>";
                            echo "<ul>";
                            foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) {
                                echo "<li>" . $container_name . "</li>";
                            }
                            echo "</ul>";
                        }
                        echo "</ul>";
                    }
                }
                ?>
            </ul>
        </main>
    </body>
</html>
