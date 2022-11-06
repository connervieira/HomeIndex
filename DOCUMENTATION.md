# Documentation

Here you can learn how to install and use Home Index.


## Installation

1. Download Home Index from the V0LT website, or another source.
2. Install Apache, or another web server host.
    - Example: `sudo apt install apache2`
3. Install and enable PHP for your webserver.
    - Example: `sudo apt install php7.4; sudo a2enmod php7.4`
4. Move the Home Index directory to a location on your webserver.
    - Example: `sudo mv homeindex/ /var/www/html/`
5. Grant PHP write permissions to the Home Index directory.
    - Example: `sudo chmod 777 /var/www/html/homeindex/`
6. Navigate to Home Index in your browser.
    - Example: `http://localhost/homeindex/`


## Configuration

1. From the main page of Home Index, press the 'Tools' button at the top of the page.
2. On the next page, press the 'Configuration' button, under the 'Main Tools' header.
3. Change configuration values as desired.
    - The 'Theme' setting defines a color scheme to be used across Home Index.
    - The 'Database Location' setting defines where Home Index will store it's item database.
        - To have the database stored in the root Home Index directory, simply prefix the file-name with `./`.
            - Example: `./itemdatabase.txt`
        - To have the database stored in a different folder, specify the full file path and file name.
    - The 'Required Username' setting defines the username that a user must have to access Home Index.
        - If this setting is left blank, anyone with access to the Home Index instance is permitted to access and edit Home Index information.
            - If you're hosting Home Index on your local network for personal access, this can be left blank to allow anyone on your home network to access Home Index.
            - If your Home Index host is publically accessible, you should use this setting to prevent unauthorized access.
        - Users that are not signed in, or don't have a username matching the required username will be denied access.
        - Home Index doesn't have a built in authentication system, but is natively compatible with V0LT DropAuth.


## Usage

### Adding Items

1. Locate the 'add item' form at the top of the main Home Index page.
2. Fill out the relevant item location and information details.
    - **Location**: The location represents the general, high-level location of them item.
        - Examples: 'Home', 'Car', 'Shed', 'Work'
    - **Space**: The space is the general space an item is in.
        - Examples: 'Bedroom', 'Trunk', 'Shelves', 'Desk'
    - **Container**: This is the specific container than an item is in.
        - Examples: 'Dresser', 'First Aid Kit', 'Tool Box', 'Top Left Drawer'
    - **Name**: This is the name of the item itself.
        - This name should be unique in it's container.
        - Examples: 'College Sweatshirt', 'Bandaids', 'Screwdriver', 'Phonebook'
    - **Description**: This field is optional, and contains a description of the item.
        - If you have any special notes about the nature of location of a particular item, you can put those notes here.
    - **Quantity**: This field contains the quantity of a particular item.
        - If you don't care about measuring the quantity of an item, just put '1'.
    - **Value**: This field contains the approximate value of an individual item.
        - If you don't care about measuring the value of an item, just put '0'.
3. Press 'Add Item'


### Modifying Items

Note: It is not possible to change the name of an item by editing it. Instead, use the 'Move Item' tool for this process.

1. Locate the item you want to modify.
2. Click the 'Edit' button to autofill the item's values in the item form at the top of the page.
3. Enter an updated description, quantity, and value.
4. Press 'Submit Item' to overwrite the old item's information.


### Deleting Items

1. Locate the item you want to delete.
2. Press the 'Delete' button.
3. On the next page, press the 'Confirm' button.
4. The item will be delete. Press 'Back' to return to the main page.


### Using Tools

Home Index has various built in tools. To get to these tools, navigate to the main Home Index page, and press the 'Tools' button at the top of the page.

- General Tools
    1. Configuration
        - The Configuration tool allows the user to customize their Home Index instance.
        - The configuration process is described in a different documentation section.
    2. About
        - The About tool allows the user to view information related to their Home Index instance.
        - This is useful for debugging purposes, and can help document and solve problems.
- Data Viewing
    1. List Items
        - The List Items tool simply outputs the entire item database in a plain text list.
        - This tool is useful for getting a general overview of your items, or for creating an easily shareable and printable format.
- Data Management
    1. Move Container
        - This tool allows the user to move or rename a container.
        - All items and container information are preserved when using this tool.
        - To use this tool, simply specify the container you want to modify by entering the location, space, and container name. Then, enter any updated information in the second part of the form.
        - Any values that are left blank in the second part of the form will be re-used from the container's original values.
            - For example, if you just want to change the name of a container, and leave it where it is, fill out its information in the first part of the form, then only fill out the 'New Container Name' field in the second part of the form. The new location and space will be left the same as the old location and space.
    2. Move Item
        - This tool allows the user to move or rename an item.
        - All item information is preserved when using this tool.
        - To use this tool, simply specify the item you want to modify by entering the location, space, container, and item name. Then, enter any updated information in the second part of the form.
        - Any values that are left blank in the second part of the form will be re-used from the item's original values.
            - For example, if you want to move the item, but not change its name, simply fill out the information in the first part of the form, then specify the new position information in the second part of the form. If the 'New Item Name' field is left blank, then the name will remain unchanged.
- Advanced Tools
    1. Dump Formatted Database
        - This tool simply takes the item database and dumps its contents in a formatted table.
        - This tool is useful for debugging and sharing your database information.
    2. Dump Raw Database
        - This tool takes the contents of the item database and dumps its raw contents into an unformatted string.
        - This tool is useful for accessing the raw item database without having physical access to the server hosting Home Index.
        - The string output by this tool is machine-readable, and doesn't contain any HTML formatting.
