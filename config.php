<?php
// This script manages the Home Index configuration. It is loaded on all Home Index pages.


// Initialize the configuration database.
if (file_exists("./configdatabase.txt") == false) { // If the database file doesn't exist, create it.
    $config_file = fopen("configdatabase.txt", "w") or die("Unable to create database file!"); // Create the file.
    fwrite($config_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($config_file); // Close the database file.

    // Set the default configuration values.
    $config["theme"] = "light";
    $config["access"] = "admin";
    $config["whitelist"] = array();
    $config["database_location"] = "./itemdatabase.txt";
    $config["admin_user"] = "";
    $config["login_page"] = "../login.php";
    $config["instance_name"] = "Home Index";
    $config["instance_tagline"] = "Organize your personal possessions";
    $config["credit_level"] = "low";
    $config["display_advanced_tools"] = false;
    $config["displayed_search_results_count"] = 10;
    $config["backup_overwriting"] = false;
    file_put_contents("./configdatabase.txt", serialize($config)); // Write the configuration database to disk.

} else { // Otherwise, the file exists, so load the configuration database from disk.
    $config = unserialize(file_get_contents('./configdatabase.txt')); // Load the configuration database from the disk.
}



?>
