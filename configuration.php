<?php
include "./config.php"; // Import the configuration library.


// Check to see if the user is signed in.
session_start();
if (isset($_SESSION['loggedin'])) {
	$username = $_SESSION['username'];
}



// Collect any information from the form that may have been submitted.
$theme = $_POST["theme"]; // This is the interface theme.
$database_location = $_POST["databaselocation"]; // This is the file path to the item database.


if ($theme != null) { // Check to see if information was input through the form.
    $config["theme"] = $theme;
    $config["database_location"] = $database_location;
    file_put_contents("./configdatabase.txt", serialize($config)); // Write database changes to disk.
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
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
