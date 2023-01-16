<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.
include "./utils.php"; // Import the utils library.

$user_database_statistics = count_user_items($username, $item_database); // Calculate the statistics for the current user's item inventory.
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
            <p>Database Location Count: <?php echo $user_database_statistics[0]; ?></p>
            <p>Database Space Count: <?php echo $user_database_statistics[1]; ?></p>
            <p>Database Container Count: <?php echo $user_database_statistics[2]; ?></p>
            <p>Database Item Count: <?php echo $user_database_statistics[3]; ?></p>
            <p>Database Item Value: $<?php echo $user_database_statistics[4]; ?></p>

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
