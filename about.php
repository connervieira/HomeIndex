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



// Count the number of items in the database.
$database_item_count = 0;

foreach ($item_database["locations"] as $location_name => $location_information) { // Iterate through all the locations in the database.
    foreach ($item_database["locations"][$location_name]["spaces"] as $space_name => $space_information) { // Iterate through all the spaces in the database.
        foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) { // Iterate through all the containers in the database.
            foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) { // Iterate through all the items in the database.
                $database_item_count = $database_item_count + 1; // Increment the item counter by 1.
            }
        }
    }
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
        <div class="button-container">
            <div class="button"><a href="index.php">Back</a></div>
        </div>

        <div class="about-container">
            <h2>Instance Information</h2>
            <?php
                if ($config["instance_name"] == "Home Index") {
                    echo "<p>Name: " . $config["instance_name"] . "</p>";
                } else {
                    echo "<p>Original Name: " . "Home Index" . "</p>";
                    echo "<p>Modified Name: " . $config["instance_name"] . "</p>";
                }
            ?>
            <?php
                if ($config["instance_tagline"] == "Organize your personal possessions") {
                    echo "<p>Tagline: " . $config["instance_tagline"] . "</p>";
                } else {
                    echo "<p>Original Tagline: " . "Organize your personal possessions" . "</p>";
                    echo "<p>Modified Tagline: " . $config["instance_name"] . "</p>";
                }
            ?>
            <p>Database Item Count: <?php echo $database_item_count; ?> </p>

            <br>
            <h2>Configuration Information</h2>
            <p>Item Database Location: <?php echo $config["database_location"]; ?></p>
            <?php
                if ($config["required_user"] == "") {
                    echo "<p>Required Authentication: False</p>";
                } else {
                    echo "<p>Required Authentication: True</p>";
                    echo "<p>Required Username: " . $config["required_user"] . "</p>";
                }
            ?>
            <p>Theme: <?php echo $config["theme"]; ?></p>
            <p>Credit Level: <?php echo $config["credit_level"]; ?></p>
        </div>
    </body>
</html>