<?php
include "./config.php"; // Import the configuration library.
include "./authentication.php"; // Import the authentication library.

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
        <main>
            <div class="button-container">
                <a class="button" href="index.php">Back</a>
            </div>

            <h1>Tools</h1>

            <h2>General Tools</h2>
            <?php
            if ($config["admin_user"] == "" or $username == $config["admin_user"]) { // Check to see if a admin username has been set.
                echo "<a class='button' href='./configuration.php'>Configuration</a><br><br><br>";
                echo "<a class='button' href='./permissions.php'>Permissions</a><br><br><br>";
            }
            ?>
            <a class="button" href='./about.php'>About</a>

            <br><br>
            <h2>Data Viewing</h2>
            <a class="button" href='./listitems.php'>List Items</a><br><br><br>
            <a class="button" href='./searchitems.php'>Search Items</a>

            <br><br>
            <h2>Data Management</h2>
            <a class="button" href='./movecontainer.php'>Move Container</a><br><br><br>
            <a class="button" href='./moveitem.php'>Move Item</a>

            <?php
            if ($config["display_advanced_tools"] == true) { // Only display the Advanced Tools section if the configuration specifies to do so.
                echo "<br><br><h2>Advanced Tools</h2>";
                echo "<a class='button' href='./dumpuserraw.php'>Dump Raw User Database</a><br><br><br>";
                if ($config["admin_user"] == "" or $username == $config["admin_user"]) { // Check to see if a admin username has been set.
                    echo "<a class='button' href='./dumpdatabase.php'>Dump Formatted Database</a><br><br><br>";
                    echo "<a class='button' href='./dumpraw.php'>Dump Raw Database</a><br><br><br>";
                    echo "<a class='button' href='./backup.php'>Backup Database</a><br><br><br>";
                    echo "<a class='button' href='./deleteuser.php'>Delete Users</a>";
                }
            }
            ?>
        </main>
    </body>
</html>
