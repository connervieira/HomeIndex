<?php
include "./config.php"; // Import the configuration library.
?>


<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $config["instance_name"]; ?> - Privacy</title>
        <link rel="stylesheet" type="text/css" href="./styles/main.css">
        <link rel="stylesheet" type="text/css" href="./styles/themes/<?php echo $config["theme"]; ?>.css">
    </head>

    <body>
        <div class="button-container">
            <a class="button" href="./about.php">Back</a>
        </div>

        <div class="about-container">
            <h2>Privacy</h2>

            <br>
            <h3>Introduction</h3>
            <p>Considering Home Index is designed specifically to index your personal possessions, it goes without saying that privacy and security are both extremely critical. This page explains how Home Index works behind the scenes, and how it relates to your privacy.</p>
            <p>Before describing how it works, it is important to explain exactly what Home Index is. Home Index is a web service developed by <a href="https://v0lttech.com">V0LT</a>. It's designed to make organizing possessions as quick, easy, and conveinent as possible. Home Index is completely open source, and can be self hosted by anyone with basic technical experience. As such, <b>V0LT doesn't necessarily control how all Home Index instances work</b>, since anyone with a copy of the software can modify it. For this reason, you should make sure you trust the entity hosting the instance you use, since they have full control over how everything works. The characteristics below assume that the Home Index instance you are using is unmodified.</p>

            <br>
            <h3>Advantages</h3>
            <p>First and foremost, Home Index has absolutely no telemetry or tracking of any kind. The information you enter into the service doesn't leave the server it's hosted on unless someone specifically moves it. V0LT doesn't track Home Index usage, or even installation statistics.</p>
            <p>Home Index makes use of input sanitization to minimize the risk of data leaks. Whenever user input is taken, malicious characters are filtered out and detected before any processing takes place. This makes the database system much more resilient to intentional or unintentional manipulation.</p>
            <p>After all else, Home Index prioritizes offline self-hosting capability, which effectively eliminates all risk of data leaks, given that only trusted users even have access to the service at all.</p>

            <br>
            <h3>Caveats</h3>
            <p>While its open source and self-hostable nature give Home Index unrivalled transparency and privacy, these characteristics have caveats that users should be aware of. As explained before, V0LT doesn't have control over 3rd party instances of Home Index, and the entities that host these instances can modify their copies of the software to have malicious modifications designed to collect private information or manipulate users. As such, you should only use instances hosted by entities that you trust to protect your data.</p>
            <p>Steps are taken to protect the internal database from leaks, but it's important to know that the database file itself is unencrypted. This means that anyone with direct access to the server hosting your instance will be able to see the complete item database. This is even further reason to either self host Home Index, or make sure you trust the owner of the instance you choose to use.</p>
        </div>
    </body>
</html>
