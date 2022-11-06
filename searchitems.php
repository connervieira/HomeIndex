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




// Load and initialize the database.
if (file_exists($config["database_location"]) == false) { // If the database file doesn't exist, create it.
    $item_database_file = fopen($config["database_location"], "w") or die("Unable to create database file!"); // Create the file.
    fwrite($item_database_file, "a:0:{}"); // Set the contents of the database file to a blank database.
    fclose($item_database_file); // Close the database file.
}

if (file_exists($config["database_location"]) == true) { // Check to see if the item database file exists. The database should have been created in the previous step if it didn't already exists.
    $item_database = unserialize(file_get_contents($config["database_location"])); // Load the database from the disk.
} else {
    echo "<p>The database failed to load</p>"; // Inform the user that the database failed to load.
    exit(); // Terminate the script.
}




// Collect any information from the form that may have been submitted.
$search_string = $_POST["search"]; // This is the string entered as a search term.


// Sanitize inputs.
$search_string = filter_var($search_string, FILTER_SANITIZE_STRING); // Sanitize the search string.


if ($search_string !== "" and $search_string !== null) { // Only run search processing if the user has entered a search term.
    // Process inputs.
    $individual_search_terms = explode(" ", $search_string); // Split the search string into individual words.

    // Create a list of every item in the database to make the searching process easier.
    $item_list = array(); // The the list of items to a blank placeholder.
    foreach ($item_database["locations"] as $location_name => $location_information) { // Iterate through all the locations in the database.
        foreach ($item_database["locations"][$location_name]["spaces"] as $space_name => $space_information) { // Iterate through all the spaces in this location.
            foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"] as $container_name => $container_information) { // Iterate through all the containers in this space.
                foreach ($item_database["locations"][$location_name]["spaces"][$space_name]["containers"][$container_name]["items"] as $item_name => $item_information) { // Iterate through all the items in this container.
                    $individual_item_information["name"] = $item_name;
                    $individual_item_information["location"] = $location_name;
                    $individual_item_information["space"] = $space_name;
                    $individual_item_information["container"] = $container_name;
                    $individual_item_information["search_score"] = (levenshtein($item_name, $search_string, 1, 4, 1)) + (40 - strlen($item_name)); // Calculate the search term match score of this item. Lower is closer.

                    // Calculate the search difference score for this item.
                    $individual_item_information["search_score"] = (levenshtein(strtolower($item_name), strtolower($search_string), 1, 4, 1)); // Calculate the search term match score of this item. Lower is closer.
                    $individual_item_information["search_score"] += (30 - strlen($item_name)); // Increase the search difference score for shorter item names, since short items will naturally be less different due to having fewer characters.
                    foreach ($individual_search_terms as $term) { // Iterate through each individual word in the search string.
                        if (strpos(strtolower($item_name), strtolower($term)) !== false) { // If a word search term exists as part of them item name, then decrease its search difference score.
                            $individual_item_information["search_score"] -= 10;
                        }
                    }
                    if (strpos(strtolower($item_name), strtolower($search_string)) !== false) { // If the complete search term exists as part of them item name, then significantly decrease its search difference score.
                        $individual_item_information["search_score"] -= 20;
                    }
                    array_push($item_list, $individual_item_information); // Add this item's information to the list.
                }
            }
        }
    }


    // Sort the item list by search term match confidence.
    $sorted_items = array(); // Set the sorted items list to a blank placeholder.
    for ($x = 0; $x <= sizeof($item_list); $x++) { // Run the loop once for every entry in the item list.
        $current_best_item["search_score"] = 100000000; // Set the current best item to a blank placeholder at the start of each round.
        $current_best_item_key = 0;
        foreach ($item_list as $key => $item) {
            if ($item["search_score"] < $current_best_item["search_score"]) { // Check to see if this item beats the current best item.
                $current_best_item = $item; // Make this item the current best item.
                $current_best_item_key = $key; // Record this item's key.
            }
        }
        array_push($sorted_items, $current_best_item); // Add the best item at the end of the round to the sorted database.
        unset($item_list[$current_best_item_key]); // Remove the best item at the end of the round from the original database.
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Item Search</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <main>
            <div class="button-container">
                <a class="button" href="./tools.php">Back</a>
            </div>
            <h1>Item Search</h1>
            <hr>
            <div class="new-item">
                <form method="POST">
                    <label for="search">Search Term: </label><input type="text" name="search" id="search" placeholder="Search Term" required><br>
                    <br><br>
                    <input class="button" type="submit" value="Submit">
                </form>
            </div>
            <?php
            if (sizeof($sorted_items) > 0) { // Only display the search results if there are search results to begin with.
                if (sizeof($sorted_items) < $config["displayed_search_results_count"]) { // Check to see if the number of results to display is bigger than the size of the results themselves.
                    $config["displayed_search_results_count"]= sizeof($sorted_items); // Default to the maximum size of the sorted items list.
                }
                for ($x = 0; $x < $config["displayed_search_results_count"]; $x++) { // Run the loop once for every entry in the item list.
                    echo "
                    <div class='location'>
                        <h3>" . $sorted_items[$x]["name"] . "</h3>
                        <p>Difference Score: " . $sorted_items[$x]["search_score"] . "</p>
                        <p>Located in <b>" . $sorted_items[$x]["container"] . "</b> in <b>" . $sorted_items[$x]["space"] . "</b> in <b>" . $sorted_items[$x]["location"] . "</b>.</p>
                    </div>
                    ";
                }
            }
            ?>
        </main>
    </body>
</html>
