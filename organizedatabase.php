<?php
include "./config.php"; // Import the authentication library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.



// Remove any empty database elements from this user.
foreach ($item_database[$username]["locations"] as $location_name => $location_information) {
    foreach ($item_database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) {
        foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) {
            if (sizeof($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"]) == 0) { // Check to see if this container is empty.
                unset($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]); // Remove the empty container.
            }
        }
        if (sizeof($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"]) == 0) { // Check to see if this space is empty.
            unset($item_database[$username]["locations"][$location_name]["spaces"][$space_name]); // Remove the empty space.
        }
    }
    if (sizeof($item_database[$username]["locations"][$location_name]["spaces"]) == 0) { // Check to see if this location is empty.
        unset($item_database[$username]["locations"][$location_name]); // Remove the empty location.
    }
}


// Remove any empty users.
foreach ($item_database as $user => $user_information) {
    if (!in_array("locations", array_keys($item_database[$user])) or sizeof($item_database[$user]["locations"]) == 0) { // Check to see if this user has no locations, and therefore has no items.
        unset($item_database[$user]); // Remove the empty user.
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



save_database($config["database_location"], $item_database, $config); // Save database changes to the disk.
?>
