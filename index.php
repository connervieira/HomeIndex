<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.
include "./utils.php"; // Import the utils library.





// Process any information submitted to the 'item creation' form.

// Collect any information from the form that may have been submitted.
$location = $_POST["location"]; // This is the location the item is in.
$space = $_POST["space"]; // This is the space the item is in.
$container = $_POST["container"]; // This is the container the item is in.
$name = $_POST["name"]; // This is the name of the item.
$description = $_POST["description"]; // This is the description of the item.
$identifier = $_POST["identifier"]; // This is the identifier of the item.
$quantity = $_POST["quantity"]; // This is the quantity of the item.
$value = $_POST["value"]; // This is the value of the item.

// Collect any autocomplete information from the URL that may have been submitted, and sanitize it.
$displayed_location = filter_var($_GET["location"], FILTER_SANITIZE_STRING); // This is the location the item is in.
$displayed_space = filter_var($_GET["space"], FILTER_SANITIZE_STRING); // This is the space the item is in.
$displayed_container = filter_var($_GET["container"], FILTER_SANITIZE_STRING); // This is the container the item is in.
$displayed_name = filter_var($_GET["name"], FILTER_SANITIZE_STRING); // This is the name of the item.
$displayed_description = filter_var($_GET["description"], FILTER_SANITIZE_STRING); // This is the description of the item.
$displayed_identifier = filter_var($_GET["identifier"], FILTER_SANITIZE_STRING); // This is the identifier of the item.
$displayed_quantity = filter_var($_GET["quantity"], FILTER_SANITIZE_NUMBER_INT); // This is the quantity of the item.
$displayed_value = filter_var($_GET["value"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // This is the value of the item.

// Sanitize inputs.
$location = filter_var($location, FILTER_SANITIZE_STRING); // Sanitize the location string.
$space = filter_var($space, FILTER_SANITIZE_STRING); // Sanitize the space string.
$container = filter_var($container, FILTER_SANITIZE_STRING); // Sanitize the container string.
$name = filter_var($name, FILTER_SANITIZE_STRING); // Sanitize the name string.
$description = filter_var($description, FILTER_SANITIZE_STRING); // Sanitize the description string.
$identifier = filter_var($identifier, FILTER_SANITIZE_STRING); // Sanitize the identifier string.
$quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT); // Sanitize the quantity integer number.
$value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // Sanitize the value floating point number.

// Verify input lengths.
if (strlen($location) > 512) { echo "<p>The 'location' field is longer than expected.</p>"; exit(); }
if (strlen($space) > 512) { echo "<p>The 'space' field is longer than expected.</p>"; exit(); }
if (strlen($container) > 512) { echo "<p>The 'container' field is longer than expected.</p>"; exit(); }
if (strlen($name) > 512) { echo "<p>The 'name' field is longer than expected.</p>"; exit(); }
if (strlen($description) > 4096) { echo "<p>The 'description' field is longer than expected.</p>"; exit(); }
if (strlen($identifier) > 2048) { echo "<p>The 'identifier' field is longer than expected.</p>"; exit(); }
if ($quantity > 2**32) { echo "<p>The 'quantity' field input is excessively high.</p>"; exit(); }
if ($value > 2**32) { echo "<p>The 'quantity' field input is excessively high.</p>"; exit(); }



if ($displayed_location == "" or $displayed_location == null) { // If no location is set to be displayed, then fall back to the information from the last item.
    $displayed_location = $location;
}
if ($displayed_space == "" or $displayed_space == null) { // If no space is set to be displayed, then fall back to the information from the last item.
    $displayed_space = $space;
}
if ($displayed_container == "" or $displayed_container == null) { // If no container is set to be displayed, then fall back to the information from the last item.
    $displayed_container = $container;
}



// Check to see how many items this user is permitted to have.
if ($item_database[$username]["permissions"]["maxitems"] == 0) { // Check to see if the user is missing a max-item permission override.
    $user_max_items = $config["default_max_items"]; // Use the default maximum item count.
} else {
    $user_max_items = $item_database[$username]["permissions"]["maxitems"]; // Use this user's individual maximum item override.
}
$current_user_item_count = count_user_items($username, $item_database)[3]; // Calculate the number of items in the current user's item database.

if ($current_user_item_count >= $user_max_items) { // Check to see if the user has already reached the maximum allowed item count.
    $item_limit_reached = true;
} else {
    $item_limit_reached = false;
}



// Convert the item information into an array.
$item_information = ["description" => $description, "identifier" => $identifier,"quantity" => intval($quantity), "value" => floatval($value)];


// Add the item to the item database.
if ($location != null and $space != null and $container != null) { // Check to see if form data has been submitted.
    if ($item_limit_reached == true) { // Check to see if the user has already reached the maximum allowed item count, as calculated earlier.
        echo "<p>You've reached the maximum allowed number of items! Before adding more items, please remove existing items or upgrade the number of items you're permitted to have.</p>";
        exit();
    }
    $item_database[$username]["locations"][$location]["spaces"][$space]["containers"][$container]["items"][$name] = $item_information; // Append the item to the loaded item database.
    save_database($config["database_location"], $item_database, $config); // Save database changes to the disk.
}




include "./organizedatabase.php"; // Execute the database organization script.
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
            <?php
            if ($item_limit_reached == true) { // If the item limit has been reached, hide the item add input form.
                echo "<p>You've reached the maximum number of allowed items. Please remove some items, or upgrade your account.</p>";
            } else { // If the item limit has not been reached, then display the item add form normally.
                echo "<form method='POST'>";
                echo "    <label for='location'>Location: </label><input type='text' name='location' id='location' placeholder='Location' value='" . $displayed_location. "' required><br>";
                echo "    <label for='space'>Space: </label><input type='text' name='space' id='space' placeholder='Space' value='" . $displayed_space . "' required><br>";
                echo "    <label for='container'>Container: </label><input type='text' name='container' id='container' placeholder='Container' value='" . $displayed_container . "' required><br>";
                echo "    <hr>";
                echo "    <label for='name'>Name: </label><input type='text' name='name' id='Name' placeholder='name' value='" . $displayed_name . "' required><br>";
                echo "    <label for='description'>Description: </label><input type='text' name='description' id='description' placeholder='Description' value='" . $displayed_description ."'><br>";
                echo "    <label for='identifier'>Identifier: </label><input type='text' name='identifier' id='identifier' placeholder='Identifier' value='" . $displayed_identifier . "'><br>";
                echo "    <label for='quantity'>Quantity: </label><input type='number' name='quantity' id='quantity' placeholder='Quantity' value='"; if ($displayed_quantity !== "" and $displayed_quantity !== null) { echo $displayed_quantity; } else { echo "1"; } echo "' required><br>";
                echo "    <label for='value'>Value: </label><input type='number' name='value' id='Value' placeholder='Value' step='0.01' value='"; if ($displayed_value !== "" and $displayed_value !== null) { echo $displayed_value; } else { echo "0"; } echo "' required>";
                echo "    <br><br>";
                echo "    <input class='button' type='submit' value='Submit Item'>";
                echo "</form>";
            }
            ?>
        </div>

        <br><a class="button" href=".">Clear</a><br><br>

        <hr>
        <div class="posts-view">
            <?php
                if (sizeof($item_database[$username]) > 0) { // Only display the information in the item database there is actually information to show.
                    foreach ($item_database[$username]["locations"] as $location_name => $location_information) {
                        echo "<div class='location'>";
                        echo "<a class='sectiontitle' href='?location=" . $location_name . "'><h1 id='" . $location_name . "'>" . $location_name . "</h1></a>";
                        foreach ($item_database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) {
                            echo "<div class='space'>";
                            echo "<a class='sectiontitle' href='?location=" . $location_name . "&space=" . $space_name . "'><h2 id='"  . $location_name . "-" . $space_name . "'>" . $space_name . "</h2></a>";
                            foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) {
                                echo "<div class='container'>";
                                echo "<a class='sectiontitle' href='?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "'><h3 id='" . $location_name . "-" . $space_name . "-" . $container_name . "'>" . $container_name . "</h3></a>";
                                foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) {
                                    echo "<div class='item' id='" . $location_name . " - " . $space_name . " - " . $container_name . " - " . $item_name . "'>";
                                    echo "<h4 id='" . $location_name . " - " . $space_name . " - " . $container_name . " - " . $item_name . "'>" . $item_name . "</h4>";
                                    if ($item_information["description"] != "") {
                                        echo "<p>Description: " . $item_information["description"] . "</p>";
                                    }
                                    if ($item_information["identifier"] != "") {
                                        echo "<p>Identifier: " . $item_information["identifier"] . "</p>";
                                    }
                                    echo "<p>Quantity: " . $item_information["quantity"] . " $" . $item_information["value"] . " ($" . intval($item_information["quantity"]) * floatval($item_information["value"]) . ")</p>";
                                    echo "<a class='button' href='?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "&name=" . $item_name . "&value=" . $item_information["value"] . "&quantity=" . $item_information["quantity"] . "&description=" . $item_information["description"] . "&identifier=" . $item_information["identifier"] . "'>Edit</a>";
                                    echo "<a class='button' href='./deleteitem.php?location=" . $location_name . "&space=" . $space_name . "&container=" . $container_name . "&item=" . $item_name . "'>Delete</a>";
                                    echo "<a class='button' href='./moveitem.php?autolocation=" . $location_name . "&autospace=" . $space_name . "&autocontainer=" . $container_name . "&autoitem=" . $item_name . "'>Move</a>";
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
