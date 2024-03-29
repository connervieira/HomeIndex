<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./utils.php"; // Import the utils library.




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




// Collect any information from the form that may have been submitted.
$old_location = $_POST["location1"]; // This is the location the container is in.
$old_space = $_POST["space1"]; // This is the space the the container is in.
$old_container = $_POST["container1"]; // This is the container to be moved.
$new_location = $_POST["location2"]; // This is the location the container is being moved to.
$new_space = $_POST["space2"]; // This is the space the container is being moved to.
$new_container = $_POST["container2"]; // This is the container to be moved.


// Sanitize inputs.
$old_location = filter_var($old_location, FILTER_SANITIZE_STRING); // Sanitize the old location string.
$old_space = filter_var($old_space, FILTER_SANITIZE_STRING); // Sanitize the old space string.
$old_container = filter_var($old_container, FILTER_SANITIZE_STRING); // Sanitize the old container string.
$new_location = filter_var($new_location, FILTER_SANITIZE_STRING); // Sanitize the new location string.
$new_space = filter_var($new_space, FILTER_SANITIZE_STRING); // Sanitize the new space string.
$new_container = filter_var($new_container, FILTER_SANITIZE_STRING); // Sanitize the new container string.


if ($new_location == "" or $new_location == null) { // Check to see if the new location name was left blank.
    $new_location = $old_location; // Use the same location name from the old location.
}
if ($new_space == "" or $new_space == null) { // Check to see if the new location name was left blank.
    $new_space = $old_space; // Use the same location name from the old location.
}
if ($new_container == "" or $new_container == null) { // Check to see if the new container name was left blank.
    $new_container = $old_container; // Use the same container name from the old container.
}


if ($old_location !== null and $old_location !== "" and $old_space !== null and $old_space !== "" and $old_container !== null and $old_container !== "") { // Check to see if information was entered for the old container information.
    if ($old_location !== $new_location or $old_space !== $new_space or $old_container !== $new_container) {
        if ($new_location !== null and $new_location !== "") { // Check to make sure a new location was specified.
            if ($new_space !== null and $new_space !== "") { // Check to make sure a new space was specified.
                if (isset($item_database[$username]["locations"][$old_location]["spaces"][$old_space]["containers"][$old_container]) == true) { // Check to make sure the specified container actually exists.
                    $item_database[$username]["locations"][$new_location]["spaces"][$new_space]["containers"][$new_container] = $item_database[$username]["locations"][$old_location]["spaces"][$old_space]["containers"][$old_container]; // Move the original container's information to the new container.
                    unset($item_database[$username]["locations"][$old_location]["spaces"][$old_space]["containers"][$old_container]); // Remove the container from the old location.
                    save_database($config["database_location"], $item_database, $config); // Save database changes to the disk.
                    echo "<p>Successfully moved container.</p>";
                } else {
                    echo "<p>The container specified does not exist.</p>";
                }
            } else {
                echo "<p>No new space was specified.</p>";
            }
        } else {
            echo "<p>No new location was specified.</p>";
        }
    } else {
        echo "<p>The container was unchanged.</p>";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Move Container</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <main>
            <div class="button-container">
                <a class="button" href="./tools.php">Back</a>
            </div>
            <h1>Move Container</h1>
            <hr>
            <div class="new-item">
                <form method="POST">
                    <label for="location1">Original Location: </label><input type="text" name="location1" id="location1" placeholder="Starting Location" required><br>
                    <label for="space1">Original Space: </label><input type="text" name="space1" id="space1" placeholder="Starting Space" required><br>
                    <label for="container1">Original Container Name: </label><input type="text" name="container1" id="container1" placeholder="Original Container" required><br>
                    <hr>
                    <label for="location2">New Location: </label><input type="text" name="location2" id="location2" placeholder="Ending Location"><br>
                    <label for="space2">New Space: </label><input type="text" name="space2" id="space2" placeholder="Ending Space"><br>
                    <label for="container2">New Container Name: </label><input type="text" name="container2" id="container2" placeholder="Ending Container"><br>
                    <br><br>
                    <input class="button" type="submit" value="Submit">
                </form>
            </div>
        </main>
    </body>
</html>
