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

1. Locate the item you want to modify.
2. Note the item's exact location, space, container, and name.
3. Enter the item's location, space, container, and name in the 'add item' form at the top of the main page.
4. Enter an updated description, quantity, and value.
5. Press 'Add Item' to overwrite the old item's information.


### Deleting Items

1. Locate the item you want to delete.
2. Press the 'Delete' button.
3. On the next page, press the 'Confirm' button.
4. The item will be delete. Press 'Back' to return to the main page.
