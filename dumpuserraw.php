<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.

$database_to_display[$username] = $item_database[$username];

echo serialize($database_to_display);

?>
