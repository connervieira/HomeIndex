<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.

echo serialize($item_database[$username]);

?>
