<?php
include "./config.php"; // Import the configuration library.
$admin_only = true;
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.
?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Index</title>
    </head>

    <body>
        <pre><?php print_r($item_database) ?></pre>
    </body>
</html>
