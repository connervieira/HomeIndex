<?php
include "./config.php"; // Import the authentication library.
include "./authentication.php"; // Import the authentication library.



// Initialize the database.
if (file_exists($config["database_location"]) == false) { // If the database file doesn't exist, create it.
    $item_database_file = fopen($config["database_location"], "w") or die("Unable to create database file!"); // Create the file.
    fwrite($item_database_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($item_database_file); // Close the database file.
}



// Load the database.
if (file_exists($config["database_location"]) == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $item_database = unserialize(file_get_contents($config["database_location"])); // Load the database from the disk.
    if (!isset($item_database[$username])) { // Check to see if the user already exists in the item database.
        $item_database[$username] = array();
    }
} else {
    echo "<p>The database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}




// Remove any empty database elements.
foreach ($item_database[$username]["locations"] as $location_name => $location_information) {
    if (sizeof($item_database[$username]["locations"][$location_name]["spaces"]) == 0) { // Check to see if this location is empty.
        unset($item_database[$username]["locations"][$location_name]); // Remove the empty location.
    }
    foreach ($item_database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) {
        if (sizeof($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"]) == 0) { // Check to see if this space is empty.
            unset($item_database[$username]["locations"][$location_name]["spaces"][$space_name]); // Remove the empty space.
        }
        foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) {
            if (sizeof($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"]) == 0) { // Check to see if this container is empty.
                unset($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]); // Remove the empty container.
            }
        }
    }
}



// Sort the item database.
foreach ($item_database[$username]["locations"] as $location_name => $location_information) { // Iterate through all the locations in the database.
    foreach ($item_database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) { // Iterate through all the spaces in the database.
        foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) { // Iterate through all the containers in the database.
            ksort($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"]); // Sort the items.
        }
        ksort($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"]); // Sort the containers.
    }
    ksort($item_database[$username]["locations"][$location_name]["spaces"]); // Sort the spaces.
}
if (isset($item_database[$username]["locations"]) == true) { // Only sort the locations if the locations field exists at all.
    ksort($item_database[$username]["locations"]); // Sort the locations.
}



file_put_contents($config["database_location"], serialize($item_database)); // Write database changes to disk.
?>
