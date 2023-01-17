<?php
include "./config.php"; // Import the configuration library.
include "./database.php"; // Import the database library.
include "./utils.php"; // Import the utils library.
$admin_only = true;
include "./authentication.php"; // Import the authentication library.




// Get autofill information from the URL, if it exists.
$autouser = $_GET["autouser"];
$automaxitems = $_GET["automaxitems"];

// Sanitize the information from the URL.
if ($autouser != filter_var($autouser, FILTER_SANITIZE_STRING)) { echo "<p>Autofill manipulation detected.</p>"; exit(); } // Sanitize the 'username' input.
$automaxitems = intval($automaxitems);



// Get the inputs from the form data, if it exists.
$user = $_POST["user"];
$max_items = $_POST["maxitems"];

// Sanitize inputs.
if ($user != filter_var($user, FILTER_SANITIZE_STRING)) { echo "<p>Form manipulation detected.</p>"; exit(); } // Sanitize the 'username' input.
$max_items = intval($max_items); if ($max_items < 0) { echo "<p>Form manipulation detected</p>"; exit(); } // Sanitize the 'max items' input.



// Process any form input information.
if ($user != null and $user != "") { // Check to see if information was input through the form.
    $item_database[$user]["permissions"]["maxitems"] = $max_items;

    save_database($config["database_location"], $item_database, $config); // Save database changes to the disk.
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Permissions</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="./tools.php">Back</a>
        </div>
        <form method="POST">
            <label for="user">User: </label><input id="user" name="user" type="text" value="<?php echo $autouser; ?>" placeholder="Username">
            <br><br>
            <label for="maxitems">Max Items: </label><input id="maxitems" name="maxitems" type="number" step="1" min="0" value="<?php echo $automaxitems; ?>" placeholder="1000 items">
            <br><br>
            <input type="submit" value="Submit">
            <div class="new-item">
                <?php
                foreach ($item_database as $database_user => $user_information) {
                    if ($database_user != null and $database_user != "") { // Check to make sure this user from the database is a valid user. This is designed to filter out broken information from improper database migration.
                        $user_max_items = round(intval($item_database[$database_user]["permissions"]["maxitems"]));
                        echo "<p><a href='?autouser=" . $database_user . "&automaxitems=" . $user_max_items . "'>" . $database_user . "</a> - ";
                        if ($user_max_items == 0) {
                            echo "default";
                        } else {
                            echo $user_max_items;
                        }
                        echo " max items</p>";
                    }
                }
                ?>
            </div>
        </form>
    </body>
</html>
