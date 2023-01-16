<?php
include "./config";

// Check to see if the user is signed in.
session_start();
if (isset($_SESSION['loggedin'])) {
	$username = $_SESSION['username'];
} else {
    header("Location: " . $config["login_page"]);
    exit(); // Quit loading the rest of the page.
}



if ($admin_only == true or $config["access"] == "admin") { // Check to see if only the admin is allowed to access this page.
    if ($config["admin_user"] != "") { // Check to see if a admin username has been set.
        if ($username != $config["admin_user"]) { // Check to see if the current user's username matches the required username.
            echo "Permission denied"; // If not, deny the user access to this page.
            exit(); // Quit loading the rest of the page.
        }
    }
} else if ($config["access"] == "whitelist") { // Check to see if only whitelisted users are allowed to access this page.
    if (!in_array($username, $config["whitelist"]) and $username != $config["admin_user"]) { // Check to see if the current user is either an admin, or in the list of whitelisted users.
        echo "Permission denied"; // If not, deny the user access to this page.
        exit(); // Quit loading the rest of the page.
    }
} else if ($config["access"] == "all") { // Everyone with a username is allowed to access this page.
    if ($username == "") {
        echo "Permission denied"; // If not, deny the user access to this page.
        exit(); // Quit loading the rest of the page.
    }
}



?>
