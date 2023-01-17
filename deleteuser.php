<?php
include "./config.php"; // Import the configuration library.
$admin_only = true;
include "./authentication.php"; // Import the authentication library.
include "./database.php"; // Import the database library.
include "./utils.php"; // Import the utils library.


$autofill_user = $_GET["autofilluser"];
$user_to_delete = $_POST["user_to_delete"];


if (strlen($autofill_user) > 1024 or $autofill_user != filter_var($autofill_user, FILTER_SANITIZE_STRING)) { echo "<p>The autofill username from the URL appears to have been manipulated.</p>"; exit(); } // Sanitize the autofill username.
if (strlen($user_to_delete) > 1024 or $user_to_delete != filter_var($user_to_delete, FILTER_SANITIZE_STRING)) { echo "<p>The username to delete is malformed.</p>"; exit(); } // Sanitize the username to delete.


if ($user_to_delete != "" and $user_to_delete != null) {
    if (isset($item_database[$user_to_delete])) {
        unset($item_database[$user_to_delete]); // Remove the user from the item database.
        file_put_contents($config["database_location"], serialize($item_database)); // Write database changes to disk.
        echo "<p>The specified user has been deleted.</p>";
    } else {
        echo "<p>The specified user does not exist.</p>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - User Deletion</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <main>
            <div class="button-container">
                <a class="button" href="./tools.php">Back</a>
            </div>
            <h1>User Deletion</h1>
            <hr>
            <div class="new-item">
                <form method="POST">
                    <label for="user_to_delete">User: </label><input type="text" name="user_to_delete" id="user_to_delete" placeholder="Username To Delete" value="<?php echo $autofill_user; ?>" required><br>
                    <input class="button" type="submit" value="Delete">
                </form>
            </div>
            <div class="new-item">
                <?php
                foreach ($item_database as $user => $user_information) {
                    echo "<p><a href='?autofilluser=" . $user . "'>" . $user . "</a> - " . count_user_items($user, $item_database)[3] . " items</p>";
                }
                ?>
            </div>
        </main>
    </body>
</html>
