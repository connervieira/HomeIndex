<?php
include "./config.php"; // Import the configuration library.
$admin_only = true;
include "./authentication.php"; // Import the authentication library.



// Collect any information from the form that may have been submitted.
$theme = $_POST["theme"]; // This is the interface theme.
$admin_user = $_POST["adminuser"]; // This is the username of the instance administrator.
$access = $_POST["access"]; // This determines who can access this Home Index instance.
$whitelist = $_POST["whitelist"]; // This is a list that determine which users can access Home Index when the "whitelist" access setting is selected.
$database_location = $_POST["databaselocation"]; // This is the file path to the item database.
$login_page = $_POST["loginpage"]; // This is the page that the user will be redirected to when they attempt to login.
$instance_name = $_POST["instancename"]; // This is the display name of this instance.
$instance_tagline = $_POST["instancetagline"]; // This is the displayed tagline of this instance.
$credit_level = $_POST["creditlevel"]; // This is the level of credit given to V0LT on the main page.
$display_advanced_tools = $_POST["displayadvancedtools"]; // This determines whether or not the advanced tools section will be displayed on the tools page.
$displayed_search_results_count = $_POST["displayedsearchresultscount"]; // This is the number of results that will be displayed in the Search tool.
$backup_overwriting = $_POST["backupoverwriting"]; // This determines whether the database backup tool will allow the user to overwrite existing files.
$auto_backup = $_POST["autobackup"]; // This determines where automatic backups will be created.
$auto_backup_interval = $_POST["autobackupinterval"]; // This determines how often automatic backups can be created.
$default_max_items = $_POST["defaultmaxitems"]; // This determines the maximum number of items that a user can have in their database by default.
$use_landing_page = $_POST["uselandingpage"]; // This determines whether Home Index will redirect unauthenticated users to a landing page instead of directly to the login page.



// Sanitize configuration inputs.
if ($theme != "" and $theme != "light" and $theme != "dark" and $theme != "rainbow" and $theme != "contrast" and $theme != "metallic") {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if (strlen($admin_user) > 1024) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($admin_user != filter_var($admin_user, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if ($access != "" and $access != "everyone" and $access != "whitelist" and $access != "admin") {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if (strlen($whitelist) > 32768) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($whitelist != filter_var($whitelist, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if (strlen($database_location) > 512) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($database_location != filter_var($database_location, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if (strlen($login_page) > 512) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($login_page != filter_var($login_page, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if (strlen($instance_name) > 64) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($instance_name != filter_var($instance_name, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if (strlen($instance_tagline) > 1024) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($instance_tagline != filter_var($instance_tagline, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if ($credit_level != "" and $credit_level != "high" and $credit_level != "low" and $credit_level != "off") {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

if ($display_advanced_tools == "on") { $display_advanced_tools = true; } else { $display_advanced_tools = false; } // Convert the 'display advanced tools' setting to a bool.

$displayed_search_results_count = intval($displayed_search_results_count);

if ($backup_overwriting == "on") { $backup_overwriting = true; } else { $backup_overwriting = false; } // Convert the 'backup overwriting' setting to a bool.

if (strlen($auto_backup) > 2048) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}
if ($auto_backup != filter_var($auto_backup, FILTER_SANITIZE_STRING)) {
    echo "<p>Form manipulation detected.</p>";
    exit();
}

$auto_backup_interval = intval($auto_backup_interval);

$default_max_items = intval($default_max_items);

if ($use_landing_page == "on") { $use_landing_page = true; } else { $use_landing_image = false; } // Convert the 'display advanced tools' setting to a bool.




// Convert the raw whitelist input string into a list array.
$whitelist = explode(",", $whitelist);
foreach ($whitelist as $key => $user) { // Iterate through all users in the list of whitelisted users.
    $whitelist[$key] = trim($user); // Trim any leading or trailing blank spaces for each user.
    if ($whitelist[$key] == "") { // Check to see if this entry is empty.
        unset($whitelist[$key]); // Remove this entry.
    }
}










if ($theme != null) { // Check to see if information was input through the form.
    $config["theme"] = $theme;
    $config["admin_user"] = $admin_user;
    $config["access"] = $access;
    $config["whitelist"] = $whitelist;
    $config["database_location"] = $database_location;
    $config["login_page"] = $login_page;
    $config["instance_name"] = $instance_name;
    $config["instance_tagline"] = $instance_tagline;
    $config["credit_level"] = $credit_level;
    $config["display_advanced_tools"] = $display_advanced_tools;
    $config["displayed_search_results_count"] = $displayed_search_results_count;
    $config["backup_overwriting"] = $backup_overwriting;
    $config["auto_backup"] = $auto_backup;
    $config["auto_backup_interval"] = $auto_backup_interval;
    $config["default_max_items"] = $default_max_items;
    $config["use_landing_page"] = $use_landing_page;


    file_put_contents("./configdatabase.txt", serialize($config)); // Write database changes to disk.
}



$formatted_whitelist = "";
foreach ($config["whitelist"] as $user) { // Iterate through all users in the list of permitted extensions.
    $formatted_whitelist = $formatted_whitelist . "," . $user; // Add this extension to the list with a comma separator.
}
$formatted_whitelist = substr($formatted_whitelist, 1); // Remove the first character, since it will always be a comma.



?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Configuration</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="./tools.php">Back</a>
        </div>
        <form method="POST">
            <label for='theme' title='The aesthetic theme used by the interface for all users'>Theme:</label>
            <select id='theme' name='theme'>
                <option value='light' <?php if ($config["theme"] == "light") { echo "selected"; } ?>>Light</option>
                <option value='dark' <?php if ($config["theme"] == "dark") { echo "selected"; } ?>>Dark</option>
                <option value='contrast' <?php if ($config["theme"] == "contrast") { echo "selected"; } ?>>Contrast</option>
                <option value='metallic' <?php if ($config["theme"] == "metallic") { echo "selected"; } ?>>Metallic</option>
                <option value='rainbow' <?php if ($config["theme"] == "rainbow") { echo "selected"; } ?>>Rainbow</option>
            </select>
            <br><br>
            <label for="adminuser" title='The name of the user who can configure this instance'>Administrator: </label><input id="adminuser" name="adminuser" type="text" value="<?php echo $config["admin_user"]; ?>" placeholder="Admin User">
            <br><br>
            <label for='access' title='Determines who is allowed to access this Home Index instance'>Access:</label>
            <select id='access' name='access'>
                <option value='everyone' <?php if ($config["access"] == "everyone") { echo "selected"; } ?> title='anyone with an account'>Everyone</option>
                <option value='whitelist' <?php if ($config["access"] == "whitelist") { echo "selected"; } ?> title='any account in the whitelist'>Whitelist</option>
                <option value='admin' <?php if ($config["access"] == "admin") { echo "selected"; } ?> title='only the administrator'>Admin</option>
            </select>
            <br><br>
            <label for="whitelist" title="A comma-separated list of users who are allowed to use this Home Index instance">Whitelist: </label><input id="whitelist" name="whitelist" type="text" value="<?php echo $formatted_whitelist; ?>" placeholder="user1,user2,user3">
            <br><br>
            <label for="databaselocation" title='The file-path of the Home Index database file'>Database Location: </label><input id="databaselocation" name="databaselocation" type="text" value="<?php echo $config["database_location"]; ?>" placeholder="Database Location">
            <br><br>
            <label for="loginpage" title="The URL of the DropAuth-compatible login page for this instance">Login Page: </label><input id="loginpage" name="loginpage" type="text" value="<?php echo $config["login_page"]; ?>" placeholder="/login.php">
            <br><br>
            <label for="instancename" title="The name used for this instance of Home Index">Instance Name: </label><input id="instancename" name="instancename" type="text" value="<?php echo $config["instance_name"]; ?>" placeholder="Instance Name">
            <br><br>
            <label for="instancetagline" title="The tagline used for this instance of Home Index">Instance Tagline: </label><input id="instancetagline" name="instancetagline" type="text" value="<?php echo $config["instance_tagline"]; ?>" placeholder="Instance Tagline">
            <br><br>
            <label for='creditlevel' title="The level of credit given to V0LT from the development of Home Index">Credit Level:</label>
            <select id='creditlevel' name='creditlevel'>
                <option value='high' <?php if ($config["credit_level"] == "high") { echo "selected"; } ?>>High</option>
                <option value='low' <?php if ($config["credit_level"] == "low") { echo "selected"; } ?>>Low</option>
                <option value='off' <?php if ($config["credit_level"] == "off") { echo "selected"; } ?>>Off</option>
            </select>
            <br><br>
            <label for="displayadvancedtools" title="Determines whether advanced tools are displayed on the tools page">Display Advanced Tools: </label><input id="displayadvancedtools" name="displayadvancedtools" type="checkbox" <?php if ($config["display_advanced_tools"] == true) { echo "checked"; } ?>>
            <br><br>
            <label for="displayedsearchresultscount" title="Determines how many results are displayed on the search page">Displayed Search Results: </label><input id="displayedsearchresultscount" name="displayedsearchresultscount" type="number" placeholder="Displayed Search Results Count" value="<?php echo $config["displayed_search_results_count"]; ?>">
            <br><br>
            <label for="backupoverwriting" title="Determines whether administrators can manually overwrite existing backups using the backup tool">Backup Overwriting: </label><input id="backupoverwriting" name="backupoverwriting" type="checkbox" <?php if ($config["backup_overwriting"] == true) { echo "checked"; } ?>>
            <br><br>
            <label for="autobackup" title="This is where the Home Index database file will be backed up to">Auto-Backup Path: </label><input id="autobackup" name="autobackup" type="text" value="<?php echo $config["auto_backup"]; ?>" placeholder="/home/user/BackupFile">
            <br><br>
            <label for="autobackupinterval" title="Automatically back up the database when changes are made if it has been more than N seconds since the last backup">Auto-Backup Interval: </label><input id="autobackupinterval" name="autobackupinterval" type="number" step="0" min="1" value="<?php echo $config["auto_backup_interval"]; ?>" placeholder="60 seconds">
            <br><br>
            <label for="defaultmaxitems" title="The maximum amount of items a user can have by default">Default Max Items: </label><input id="defaultmaxitems" name="defaultmaxitems" type="number" step="1" min="1" value="<?php echo $config["default_max_items"]; ?>" placeholder="1000 items">
            <br><br>
            <label for="uselandingpage" title="Determines if unauthenticated users will be sent to a landing page explaining Home Index">Use Landing Page: </label><input id="uselandingpage" name="uselandingpage" type="checkbox" <?php if ($config["use_landing_page"] == true) { echo "checked"; } ?>>
            <br><br>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
