<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.




$database_location_count = 0;
$database_space_count = 0;
$database_container_count = 0;
$database_item_count = 0;
$database_value = 0;

// Iterate through all items in the database.
foreach ($item_database[$username]["locations"] as $location_name => $location_information) { // Iterate through all the locations in the database.
    $database_location_count = $database_location_count + 1; // Increment the location counter by 1.
    foreach ($item_database[$username]["locations"][$location_name]["spaces"] as $space_name => $space_information) { // Iterate through all the spaces in the database.
        $database_space_count = $database_space_count + 1; // Increment the space counter by 1.
        foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) { // Iterate through all the containers in the database.
            $database_container_count = $database_container_count + 1; // Increment the container counter by 1.
            foreach ($item_database[$username]["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) { // Iterate through all the items in the database.
                $database_item_count = $database_item_count + 1; // Increment the item counter by 1.
                $database_value = $database_value + ($item_information["quantity"] * $item_information["value"]);
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
        <title><?php echo $config["instance_name"]; ?> - About</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="./tools.php">Back</a>
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

            <br>
            <h2>Database Information</h2>
            <p>Database Location Count: <?php echo $database_location_count; ?></p>
            <p>Database Space Count: <?php echo $database_space_count; ?></p>
            <p>Database Container Count: <?php echo $database_container_count; ?></p>
            <p>Database Item Count: <?php echo $database_item_count; ?></p>
            <p>Database Item Value: $<?php echo $database_value; ?></p>

            <?php
            if ($config["admin_user"] == "" or $username == $config["admin_user"]) { // Check to see if a admin username has been set.
                echo "<br>";
                echo "<h2>Configuration Information</h2>";
                echo "<p>Item Database Location: " . $config["database_location"] . "</p>";
                echo "<p>Theme: " . $config["theme"] . "</p>";
                echo "<p>Access: " . $config["access"] . "</p>";
                echo "<p>Credit Level: " . $config["credit_level"] . "</p>";
            }
            ?>
        </div>
    </body>
</html>
