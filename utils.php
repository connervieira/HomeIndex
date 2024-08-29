<?php
include "./database.php";
include "./config.php";

function save_database($location, $contents, $config) {
    $auto_backup_file_interval = $config["auto_backup_interval"];
    if ($config["auto_backup"] != null and $config["auto_backup"] != "") { // Check to see if auto-backup is set and enabled.
        if (file_exists($config["auto_backup"]) == true) { // Check to make sure the auto-backup directory exists.
            if (is_writable($config["auto_backup"]) == true) { // Check to make sure the backup directory is writable.
                $backup_file_name = $config["auto_backup"] . "/HomeIndexDatabase" . (round(time() / $auto_backup_file_interval) * $auto_backup_file_interval) . ".bkp";
                if (!file_exists($config["auto_backup"] . "/" . $backup_file_name)) {
                    file_put_contents($backup_file_name, serialize($contents)); // Write the database to the backup location.
                }
            } else {
                echo "<p>The auto-backup directory is not writable.</p>";
            }
        } else {
            echo "<p>The auto-backup directory does not exist.</p>";
        }
    }

    file_put_contents($location, serialize($contents)); // Write the database information to disk.
}



function count_user_items($username, $database) {
    $database_location_count = 0;
    $database_space_count = 0;
    $database_container_count = 0;
    $database_item_count = 0;
    $database_value = 0;
    foreach ($database[$username]["locations"] as $location_name => $location_information) { // Iterate through all the locations in the database.
        $database_location_count = $database_location_count + 1; // Increment the location counter by 1.
        foreach ($database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) { // Iterate through all the spaces in the database.
            $database_space_count = $database_space_count + 1; // Increment the space counter by 1.
            foreach ($database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) { // Iterate through all the containers in the database.
                $database_container_count = $database_container_count + 1; // Increment the container counter by 1.
                foreach ($database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) { // Iterate through all the items in the database.
                    $database_item_count = $database_item_count + 1; // Increment the item counter by 1.
                    $database_value = $database_value + ($item_information["quantity"] * $item_information["value"]);
                }
            }
        }
    }
    return array($database_location_count, $database_space_count, $database_container_count, $database_item_count, $database_value);
}

?>
