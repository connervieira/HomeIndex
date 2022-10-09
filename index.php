<?php
// Check to see if the user is signed in.
session_start();
if (isset($_SESSION['loggedin'])) {
	$username = $_SESSION['username'];
}







// Load and initialize the database.

if (file_exists("./itemdatabase.txt") == false) { // If the database file doesn't exist, create it.
    $item_database_file = fopen("itemdatabase.txt", "w") or die("Unable to create database file!"); // Create the file.
    fwrite($item_database_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($item_database_file); // Close the database file.
}

if (file_exists("./itemdatabase.txt") == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $item_database = unserialize(file_get_contents('./itemdatabase.txt')); // Load the database from the disk.
} else {
    echo "<p>The database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}




// Process any information submitted to the 'item creation' form.

// Collect any information from the form that may have been submitted.
$location = $_POST["location"]; // This is the location the item is in.
$space = $_POST["space"]; // This is the space the item is in.
$container = $_POST["container"]; // This is the container the item is in.
$name = $_POST["name"]; // This is the name of the item.
$description = $_POST["description"]; // This is the description of the item.
$quantity = $_POST["quantity"]; // This is the quantity of the item.
$value = $_POST["value"]; // This is the value of the item.


// Sanitize inputs.
$location = filter_var($location, FILTER_SANITIZE_STRING); // Sanitize the location string.
$space = filter_var($space, FILTER_SANITIZE_STRING); // Sanitize the space string.
$container = filter_var($container, FILTER_SANITIZE_STRING); // Sanitize the container string.
$name = filter_var($name, FILTER_SANITIZE_STRING); // Sanitize the name string.
$description = filter_var($description, FILTER_SANITIZE_STRING); // Sanitize the description string.
$quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT); // Sanitize the quantity integer number.
$value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT); // Sanitize the value floating point number.


// Convert the item information into an array.
$item_information = ["description" => $description, "quantity" => intval($quantity), "value" => floatval($value)];


// Add the item to the item database.
if ($location != null) { // Check to see if form data has been submitted.
    $item_database["locations"][$location]["spaces"][$space]["containers"][$container]["items"][$name] = $item_information; // Append the item to the loaded item database.
}


// Sort the item database.
foreach ($item_database["locations"] as $location_name => $location_information) { // Iterate through all the locations in the database.
    foreach ($item_database["locations"][$location_name]["spaces"] as $space_name => $space_information) { // Iterate through all the spaces in the database.
        foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) { // Iterate through all the containers in the database.
            ksort($item_database["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"]); // Sort the items.
        }
        ksort($item_database["locations"][$location_name]["spaces"][$space_name]["containers"]); // Sort the containers.
    }
    ksort($item_database["locations"][$location_name]["spaces"]); // Sort the containers.
}
if (isset($item_database["locations"]) == true) { // Only sort the locations if the locations field exists at all.
    ksort($item_database["locations"]); // Sort the locations.
}


file_put_contents("./itemdatabase.txt", serialize($item_database)); // Write database changes to disk
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home Index</title>
        <link rel="stylesheet" type="text/css" href="./styles/light.css">
    </head>

    <body>
        <div class="button-container">
            <div class="button"><a href="#">Tools</a></div>
        </div>
        <h1 class="title">Home Index</h1> 
        <h3 class="subtitle">Organize and keep track of your posessions.</h3>
        <hr>
        <div class="new-item">
            <form method="POST">
                <label for="location">Location: </label><input type="text" name="location" id="location" placeholder="Location" value="<?php echo $location; ?>" required>
                <label for="space">Space: </label><input type="text" name="space" id="space" placeholder="Space" value="<?php echo $space; ?>" required>
                <label for="container">Container: </label><input type="text" name="container" id="container" placeholder="Container" value="<?php echo $container; ?>" required>
                <hr>
                <label for="name">Name: </label><input type="text" name="name" id="Name" placeholder="Name" required>
                <label for="description">Description: </label><input type="text" name="description" id="Description" placeholder="Description">
                <label for="quantity">Quantity: </label><input type="number" name="quantity" id="Quantity" placeholder="Quantity" value="1" required>
                <label for="value">Value: </label><input type="number" name="value" id="Value" placeholder="Value" value="0" step="0.01" required>
                <br><br>
                <input type="submit" value="Add Item">
            </form>
        </div>
        <div class="posts-view">
            <?php
                if (sizeof($item_database) > 0) { // Only display the information in the item database there is actually information to show.
                    foreach ($item_database["locations"] as $location_name => $location_information) {
                        echo "<div class='location'>";
                        echo "<h1>" . $location_name . "</h1>";
                        foreach ($item_database["locations"][$location_name]["spaces"] as $space_name => $space_information) {
                            echo "<div class='space'>";
                            echo "<h2>" . $space_name . "</h2>";
                            foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) {
                                echo "<div class='container'>";
                                echo "<h3>" . $container_name . "</h3>";
                                foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) {
                                    echo "<div class='item'>";
                                    echo "<h4>" . $item_name . "</h4>";
                                    echo "<p>" . $item_information["description"] . "</p>";
                                    echo "<p>" . $item_information["quantity"] . " ($" . $item_information["value"] . ")" . "</p>";
                                    echo "<div class='button'><a href='./deleteitem.php?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "&item=" . $item_name . "'>Delete</a></div>";
                                    echo "</div>";
                                }
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>There are currently no items!</p>";
                }
            ?>
        </div>
    </body>
</html>
