<?php
include "./config.php"; // Import the configuration library.



// Check to see if the user is signed in.
session_start();
if (isset($_SESSION['loggedin'])) {
	$username = $_SESSION['username'];
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

        <h1>Tools</h1>

        <h2>Main Tools</h2>
        <div class="button"><a href='./configuration.php'>Configuration</a></div>

        <br>
        <h2>Developer Tools</h2>
        <div class="button"><a href='./dumpdatabase.php'>Dump Formatted Database</a></div>
        <div class="button"><a href='./dumpraw.php'>Dump Raw Database</a></div>
    </body>
</html>
