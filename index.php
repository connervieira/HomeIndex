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




// Process any information submitted to the 'item creation' form.

// Collect any information from the form that may have been submitted.
$location = $_POST["location"]; // This is the location the item is in.
$space = $_POST["space"]; // This is the space the item is in.
$container = $_POST["container"]; // This is the container the item is in.
$name = $_POST["name"]; // This is the name of the item.
$description = $_POST["description"]; // This is the description of the item.
$quantity = $_POST["quantity"]; // This is the quantity of the item.
$value = $_POST["value"]; // This is the value of the item.

// Collect any information from the URL that may have been submitted.
$displayed_location = $_GET["location"]; // This is the location the item is in.
$displayed_space = $_GET["space"]; // This is the space the item is in.
$displayed_container = $_GET["container"]; // This is the container the item is in.
$displayed_name = $_GET["name"]; // This is the name of the item.
$displayed_description = $_GET["description"]; // This is the description of the item.
$displayed_quantity = $_GET["quantity"]; // This is the quantity of the item.
$displayed_value = $_GET["value"]; // This is the value of the item.


// Sanitize inputs.
$location = filter_var($location, FILTER_SANITIZE_STRING); // Sanitize the location string.
$space = filter_var($space, FILTER_SANITIZE_STRING); // Sanitize the space string.
$container = filter_var($container, FILTER_SANITIZE_STRING); // Sanitize the container string.
$name = filter_var($name, FILTER_SANITIZE_STRING); // Sanitize the name string.
$description = filter_var($description, FILTER_SANITIZE_STRING); // Sanitize the description string.
$quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT); // Sanitize the quantity integer number.
$value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Sanitize the value floating point number.


if ($displayed_location == "" or $displayed_location == null) { // If no location is set to be displayed, then fall back to the information from the last item.
    $displayed_location = $location;
}
if ($displayed_space == "" or $displayed_space == null) { // If no space is set to be displayed, then fall back to the information from the last item.
    $displayed_space = $space;
}
if ($displayed_container == "" or $displayed_container == null) { // If no container is set to be displayed, then fall back to the information from the last item.
    $displayed_container = $container;
}


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


file_put_contents($config["database_location"], serialize($item_database)); // Write database changes to disk.
?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?></title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="tools.php">Tools</a>
        </div>
        <h1 class="title"><?php echo $config["instance_name"]; ?></h1> 
        <h3 class="subtitle"><?php echo $config["instance_tagline"]; ?></h3>
        <?php
            if ($config["credit_level"] == "high") {
                echo '<div style="position:fixed;right:0;bottom:0;margin-right:10px;margin-bottom:10px;padding-left:5px;padding-right:5px;border-radius:5px;background:rgba(0, 0, 0, 0.75);"><p style="margin-bottom:7px;margin-top:7px;"><a href="https://v0lttech.com/madebyv0lt.php" style="text-decoration:underline;color:white;">Made by V0LT</a></p></div>';
            } else if ($config["credit_level"] == "low") {
                echo '<p style="font-size:15px;color:#cccccc;margin-top:30px;margin-bottom:30px;text-align:center;"><a href="https://v0lttech.com/madebyv0lt.php" style="text-decoration:underline;color:inherit;">Made By V0LT</a></p>';
            }
        ?>
        <hr>
        <div class="new-item">
            <form method="POST">
                <label for="location">Location: </label><input type="text" name="location" id="location" placeholder="Location" value="<?php echo $displayed_location; ?>" required><br>
                <label for="space">Space: </label><input type="text" name="space" id="space" placeholder="Space" value="<?php echo $displayed_space; ?>" required><br>
                <label for="container">Container: </label><input type="text" name="container" id="container" placeholder="Container" value="<?php echo $displayed_container; ?>" required><br>
                <hr>
                <label for="name">Name: </label><input type="text" name="name" id="Name" placeholder="Name" value="<?php echo $displayed_name; ?>" required><br>
                <label for="description">Description: </label><input type="text" name="description" id="Description" placeholder="Description" value="<?php echo $displayed_description; ?>"><br>
                <label for="quantity">Quantity: </label><input type="number" name="quantity" id="Quantity" placeholder="Quantity" value="<?php if ($displayed_quantity !== "" and $displayed_quantity !== null) { echo $displayed_quantity; } else { echo "1"; } ?>" required><br>
                <label for="value">Value: </label><input type="number" name="value" id="Value" placeholder="Value" step="0.01" value="<?php if ($displayed_value !== "" and $displayed_value !== null) { echo $displayed_value; } else { echo "0"; } ?>" required>
                <br><br>
                <input class="button" type="submit" value="Submit Item">
            </form>
        </div>

        <br><a class="button" href=".">Clear</a><br><br>

        <hr>
        <div class="posts-view">
            <?php
                if (sizeof($item_database) > 0) { // Only display the information in the item database there is actually information to show.
                    foreach ($item_database["locations"] as $location_name => $location_information) {
                        echo "<div class='location'>";
                        echo "<a class='sectiontitle' href='?location=" . $location_name . "'><h1 id='" . $location_name . "'>" . $location_name . "</h1></a>";
                        foreach ($item_database["locations"][$location_name]["spaces"] as $space_name => $space_information) {
                            echo "<div class='space'>";
                            echo "<a class='sectiontitle' href='?location=" . $location_name . "&space=" . $space_name . "'><h2 id='"  . $location_name . "-" . $space_name . "'>" . $space_name . "</h2></a>";
                            foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) {
                                echo "<div class='container'>";
                                echo "<a class='sectiontitle' href='?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "'><h3 id='" . $location_name . "-" . $space_name . "-" . $container_name . "'>" . $container_name . "</h3></a>";
                                foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) {
                                    echo "<div class='item'>";
                                    echo "<h4>" . $item_name . "</h4>";
                                    echo "<p>" . $item_information["description"] . "</p>";
                                    echo "<p>Quantity: " . $item_information["quantity"] . " $" . $item_information["value"] . " ($" . intval($item_information["quantity"]) * floatval($item_information["value"]) . ")</p>";
                                    echo "<a class='button' href='?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "&name=" . $item_name . "&value=" . $item_information["value"] . "&quantity=" . $item_information["quantity"] . "&description=" . $item_information["description"] . "'>Edit</a>";
                                    echo "<a class='button' href='./deleteitem.php?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "&item=" . $item_name . "'>Delete</a>";
                                    echo "<br><br>";
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
