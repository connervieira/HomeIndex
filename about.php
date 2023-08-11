<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.
include "./utils.php"; // Import the utils library.

$user_database_statistics = count_user_items($username, $item_database); // Calculate the statistics for the current user's item inventory.



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
            <a class="button" href="./privacy.php">Privacy</a>
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
            <h2>User Information</h2>
            <p>Capacity: <?php echo $current_user_item_count; ?> of <?php echo $user_max_items; ?> items used</p>
            <p><progress style="width:10%;height:10px;" value="<?php echo $current_user_item_count; ?>" min="0" max="<?php echo $user_max_items; ?>"></progress> <?php echo ($current_user_item_count/$user_max_items)*100; ?>% used</p>
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
