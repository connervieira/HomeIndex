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

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Tools</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="index.php">Back</a>
        </div>

        <h1>Tools</h1>

        <h2>Main Tools</h2>
        <a class="button" href='./configuration.php'>Configuration</a>
        <a class="button" href='./about.php'>About</a>

        <br><br>
        <h2>Data Viewing</h2>
        <a class="button" href='./listitems.php'>List Items</a>

        <br><br>
        <h2>Data Management</h2>
        <a class="button" href='./movecontainer.php'>Move Container</a>
        <a class="button" href='./moveitem.php'>Move Item</a>

        <br><br>
        <h2>Advanced Tools</h2>
        <a class="button" href='./dumpdatabase.php'>Dump Formatted Database</a>
        <a class="button" href='./dumpraw.php'>Dump Raw Database</a>
    </body>
</html>
