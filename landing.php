<?php
include "./config.php"; // Import the configuration library.

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?></title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="<?php echo $config["login_page"]; ?>">Login</a>
            <a class="button" href="privacy.php">Privacy</a>
        </div>
        <h1 class="title"><?php echo $config["instance_name"]; ?></h1> 
        <h3 class="subtitle"><?php echo $config["instance_tagline"]; ?></h3>
        <?php
            if ($config["credit_level"] == "high") {
                echo '<div style="position:fixed;right:0;bottom:0;margin-right:10px;margin-bottom:10px;padding-left:5px;padding-right:5px;border-radius:5px;background:rgba(0, 0, 0, 0.75);"><p style="margin-bottom:7px;margin-top:7px;"><a href="https://v0lttech.com/madebyv0lt.php" style="text-decoration:underline;color:white;">Made by V0LT</a></p></div>';
            } else if ($config["credit_level"] == "low") {
                echo '<p style="font-size:15px;color:#cccccc;margin-top:30px;margin-bottom:30px;text-align:center;"><a href="https://v0lttech.com/madebyv0lt.php" style="text-decoration:underline;color:inherit;">Made By V0LT</a></p>';
            }
        ?>
        <hr>
        <h2>Introduction</h2>
        <p>Welcome to Home Index! Home Index is an inventory management system designed around organizing your personal possessions. It follows a simple, 3 part hierarchy system. <b>Items</b> are sorted into <b>containers</b>, which are sorted into <b>spaces</b>, which are sorted into <b>locations</b>. For example, you might have bandaids, placed in a first aid kit, placed in the trunk, inside your car. Similarly, you might have a charging cable, in the top drawer, in your bedroom, in your home. This simple sorting structure makes it quick to sort your items, while still making them extremely easy to find later.</p>
        <p>If you're willing to put in the up-front time to log your possessions, Home Index makes finding the things you need extremely simple. As things are relocated, you can use built in tools to quickly move and re-name your possessions to keep your index accurate. It's difficult to appreciate how valuable Home Index is until the you experience it the first time you lose track of something. Instead of searching everywhere you can possibly think you may have stored something, just open Home Index and use the search tool to find exactly where you left it!</p>
        <p>Since you are not signed in, what you're seeing now is a demo page. The section below shows what Home Index might look like with several possessions logged. If you're interested in using Home Index for yourself, you can sign in to your account using the buttons above!</p>
        <br>
        <hr>
        <h2>Demonstration</h2>
        <p>Since you are not signed in, what you're seeing now is a demo page. The section below shows what Home Index might look like with several possessions logged. If you're interested in using Home Index for yourself, you can sign in to your account using the buttons above!</p>
        <div class="new-item">
            <br>
            <form method='POST'>
                <label for='location'>Location: </label><input type='text' name='location' id='location' placeholder='Location' disabled><br>
                <label for='space'>Space: </label><input type='text' name='space' id='space' placeholder='Space' disabled><br>
                <label for='container'>Container: </label><input type='text' name='container' id='container' placeholder='Container' disabled><br>
                <hr>
                <label for='name'>Name: </label><input type='text' name='name' id='name' placeholder='Name' disabled><br>
                <label for='description'>Description: </label><input type='text' name='description' id='description' placeholder='Description' disabled><br>
                <label for='identifier'>Identifier: </label><input type='text' name='identifier' id='identifier' placeholder='Identifier' disabled><br>
                <label for='quantity'>Quantity: </label><input type='number' name='quantity' id='quantity' placeholder='Quantity' disabled><br>
                <label for='value'>Value: </label><input type='number' name='value' id='Value' placeholder='Value' step='0.01' disabled>
                <br><br>
                <input class='button' type='submit' value='Submit Item' disabled>
            </form>
        </div>

        <br>
        <div class="posts-view">
            <div class="location">
                <h1 class="sectiontitle">Car</h1>
                <div class="space">
                    <h2 class="sectiontitle">Cabin</h2>
                    <div class="container">
                        <h3 class="sectiontitle">Center Console</h3>
                        <div class="item">
                            <h4>Flashlight</h4>
                            <p>Description: Rechargable LED handheld flashlight</p>
                            <p>Quantity: 1 $20 ($20)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Gum container</h4>
                            <p>Description: Mint gum</p>
                            <p>Quantity: 2 $1 ($2)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Registration papers</h4>
                            <p>Description: Vehicle registration</p>
                            <p>Quantity: 1 $0 ($0)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                    </div>
                    <div class="container">
                        <h3 class="sectiontitle">Glove Box</h3>
                        <div class="item">
                            <h4>Hat</h4>
                            <p>Description: Red baseball cap</p>
                            <p>Quantity: 1 $5 ($5)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Owners manual</h4>
                            <p>Description: Vehicle owner's manual</p>
                            <p>Quantity: 1 $0 ($0)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                    </div>
                </div>
                <div class="space">
                    <h2 class="sectiontitle">Trunk</h2>
                    <div class="container">
                        <h3 class="sectiontitle">First Aid Kit</h3>
                        <div class="item">
                            <h4>Bandages</h4>
                            <p>Description: Assorted adhesive bandages</p>
                            <p>Quantity: 1 $0 ($0)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Gauze</h4>
                            <p>Description: Hemostatic gauze package</p>
                            <p>Quantity: 3 $5 ($15)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Glucose</h4>
                            <p>Description: Diabetic glucose tablets in a container</p>
                            <p>Quantity: 1 $0 ($0)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="location">
                <h1 class="sectiontitle">Home</h1>
                <div class="space">
                    <h2 class="sectiontitle">Garage</h2>
                    <div class="container">
                        <h3 class="sectiontitle">Toolbox</h3>
                        <div class="item">
                            <h4>Hammer</h4>
                            <p>Description: Hammer with red handle</p>
                            <p>Quantity: 1 $5 ($5)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Screwdriver</h4>
                            <p>Description: Green flat-head screwdriver</p>
                            <p>Quantity: 1 $3 ($3)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                    </div>
                    <h2 class="sectiontitle">Bedroom</h2>
                    <div class="container">
                        <h3 class="sectiontitle">Desk</h3>
                        <div class="item">
                            <h4>Charger</h4>
                            <p>Description: Smartphone charging cable</p>
                            <p>Quantity: 1 $5 ($5)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Glasses</h4>
                            <p>Description: Reading glasses</p>
                            <p>Quantity: 1 $0 ($0)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                        <div class="item">
                            <h4>Powerbank</h4>
                            <p>Description: Black 10,000mAh power bank</p>
                            <p>Quantity: 2 $15 ($30)</p>
                            <a class="button">Edit</a>
                            <a class="button">Delete</a>
                            <a class="button">Move</a>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
