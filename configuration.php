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



// Collect any information from the form that may have been submitted.
$theme = $_POST["theme"]; // This is the interface theme.
$database_location = $_POST["databaselocation"]; // This is the file path to the item database.
$required_user = $_POST["requireduser"]; // This is the optional required username to access this instance.
$instance_name = $_POST["instancename"]; // This is the display name of this instance.
$instance_tagline = $_POST["instancetagline"]; // This is the displayed tagline of this instance.
$credit_level = $_POST["creditlevel"]; // This is the level of credit given to V0LT on the main page.
$display_advanced_tools = $_POST["displayadvancedtools"]; // This determines whether or not the advanced tools section will be displayed on the tools page.
$displayed_search_results_count = $_POST["displayedsearchresultscount"]; // This is the number of results that will be displayed in the Search tool.
$backup_overwriting = $_POST["backupoverwriting"]; // This determines whether the database backup tool will allow the user to overwrite existing files.


if ($display_advanced_tools == "on") { $display_advanced_tools = true; } else { $display_advanced_tools = false; } // Convert the 'display advanced tools' setting to a bool.
if ($backup_overwriting == "on") { $backup_overwriting = true; } else { $backup_overwriting = false; } // Convert the 'backup overwriting' setting to a bool.


if ($theme != null) { // Check to see if information was input through the form.
    $config["theme"] = $theme;
    $config["database_location"] = $database_location;
    $config["required_user"] = $required_user;
    $config["instance_name"] = $instance_name;
    $config["instance_tagline"] = $instance_tagline;
    $config["credit_level"] = $credit_level;
    $config["display_advanced_tools"] = $display_advanced_tools;
    $config["displayed_search_results_count"] = $displayed_search_results_count;
    $config["backup_overwriting"] = $backup_overwriting;
    file_put_contents("./configdatabase.txt", serialize($config)); // Write database changes to disk.
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Configuration</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="./tools.php">Back</a>
        </div>
        <form method="POST">
            <label for='theme'>Theme:</label>
            <select id='theme' name='theme'>
                <option value='light' <?php if ($config["theme"] == "light") { echo "selected"; } ?>>Light</option>
                <option value='dark' <?php if ($config["theme"] == "dark") { echo "selected"; } ?>>Dark</option>
                <option value='rainbow' <?php if ($config["theme"] == "rainbow") { echo "selected"; } ?>>Rainbow</option>
                <option value='contrast' <?php if ($config["theme"] == "contrast") { echo "selected"; } ?>>Contrast</option>
                <option value='metallic' <?php if ($config["theme"] == "metallic") { echo "selected"; } ?>>Metallic</option>
            </select>
            <br><br>
            <label for="databaselocation">Database Location: </label><input id="databaselocation" name="databaselocation" type="text" value="<?php echo $config["database_location"]; ?>" placeholder="Database Location">
            <br><br>
            <label for="requireduser">Required Username: </label><input id="requireduser" name="requireduser" type="text" value="<?php echo $config["required_user"]; ?>" placeholder="Required User">
            <br><br>
            <label for="instancename">Instance Name: </label><input id="instancename" name="instancename" type="text" value="<?php echo $config["instance_name"]; ?>" placeholder="Instance Name">
            <br><br>
            <label for="instancetagline">Instance Tagline: </label><input id="instancetagline" name="instancetagline" type="text" value="<?php echo $config["instance_tagline"]; ?>" placeholder="Instance Tagline">
            <br><br>
            <label for='creditlevel'>Credit Level:</label>
            <select id='creditlevel' name='creditlevel'>
                <option value='high' <?php if ($config["credit_level"] == "high") { echo "selected"; } ?>>High</option>
                <option value='low' <?php if ($config["credit_level"] == "low") { echo "selected"; } ?>>Low</option>
                <option value='off' <?php if ($config["credit_level"] == "off") { echo "selected"; } ?>>Off</option>
            </select>
            <br><br>
            <label for="displayadvancedtools">Display Advanced Tools: </label><input id="displayadvancedtools" name="displayadvancedtools" type="checkbox" <?php if ($config["display_advanced_tools"] == true) { echo "checked"; } ?>>
            <br><br>
            <label for="displayedsearchresultscount">Displayed Search Results: </label><input id="displayedsearchresultscount" name="displayedsearchresultscount" type="number" placeholder="Displayed Search Results Count" value="<?php echo $config["displayed_search_results_count"]; ?>">
            <br><br>
            <label for="backupoverwriting">Backup Overwriting: </label><input id="backupoverwriting" name="backupoverwriting" type="checkbox" <?php if ($config["backup_overwriting"] == true) { echo "checked"; } ?>>
            <br><br>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
