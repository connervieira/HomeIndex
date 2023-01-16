# Documentation

Here you can learn how to install, configure, and use Home Index.


## Installation

Installing Home Index is the first step in getting a self-hosted instance up and running.

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


## Authentication

In order to fully use Home Index, you'll need an authentication system. Home Index is compatible with V0LT DropAuth.


## Configuration

As an administrator, you can configure your Home Index instance to your preferences.

1. From the main page of Home Index, press the 'Tools' button at the top of the page.
2. On the next page, press the 'Configuration' button, under the 'Main Tools' header.
3. Change configuration values as desired.
    - The 'Theme' setting defines a color scheme to be used across Home Index.
    - The 'Admininstrator' setting is the username of the adminstrator of the Home Index instance.
        - The adminstrator user is the only user that can change critical settings and use secure tools.
        - If this is left blank, then any user with access to the instance will be able to make configuration changes.
    - The 'Access' option determines who can access the instance.
        - The 'Everyone' option allows anyone with a username to use Home Index.
        - The 'Whitelist' option only allows whitelisted usernames to use Home Index.
        - The 'Admin' option only allows the adminstrator user to use Home Index.
    - The 'Whitelist' setting determines which users are permitted to use Home Index when the 'Whitelist' access option is selected.
    - The 'Database Location' setting defines where Home Index will store it's item database.
        - To have the database stored in the root Home Index directory, simply prefix the file-name with `./`.
            - Example: `./itemdatabase.txt`
        - To have the database stored in a different folder, specify the full file path and file name.
    - The 'Login Page' option defines where Home Index will redirect clients who are not logged in.
    - The 'Instance Name' allows you to replace the Home Index name with a name of your own across the service.
    - The 'Instance Tagline' allows you to replace the Home Index tagline with a tagline of your own across the service.
    - The 'Credit Level' setting allows you to determine how prominently credit to V0LT will be displayed on your Home Index instance.
        - 'High' will display a small floating "Made by V0LT" message on the bottom corner of the main page.
        - 'Low' will display a small "Made by V0LT" message at the beginning of the main page.
        - 'Off' will turn off any V0LT references.
    - The 'Display Advanced Tools' determines whether or not the Advanced Tools section will be displayed on the Tools page.
    - The 'Displayed Search Result' setting determines how many search results will be displayed in the Search tool.
        - If this number is larger than the database size, then Home Index will only display the maximum available results.
    - The 'Backup Overwriting' setting determines whether or not the Backup Database tool will overwrite files if the specified file path already exists.


## Usage

Using Home Index effectively can turn it into an extremely valuable tool for organization.


### Adding Items

The more items you add to Home Index, the easier it will be to locate possessions in the future. Generally, it's easiest to empty a container like a bin or drawer, and add all of the items to Home Index one by one as you place them back in the container.

Home Index is arguably the most useful when you use it to index items that don't get used up rapidly. For example, adding a particular screwdriver to your item inventory will make it easy to find when you need it, but adding the bananas you picked up from the store is unlikely to be helpful given that they will probably go bad before you misplace them. As such, it would be a waste of time to index the things you purchase and replenish with high regularity.

Remember that adding information like descriptions and values to items might be helpful, but it's completely optional. Don't feel compelled to add extensive metadata to all of the items you index. Doing so might lead to the indexing process feeling extremely tedious. It's better to quickly add a lot of items then to feel burned out from logging too much information, and stopping early.

In short, it goes without saying that Home Index is only useful if you actually use it. As such, it's designed to be as simple or as complex as you want. Don't fall into the trap of being thorough to the point of burn out. Even just quickly adding short names for all the items in a particular area will make it dramatically easier to find misplaced items.

Below is the process for adding items to Home Index.

1. Locate the 'add item' form at the top of the main Home Index page.
2. Fill out the relevant item location and information details.
    - **Location**: The location represents the general, high-level location of them item.
        - Examples: 'Home', 'Car', 'Shed', 'Work'
    - **Space**: The space is the general space an item is in.
        - Examples: 'Bedroom', 'Trunk', 'Shelves', 'Desk'
    - **Container**: This is the specific container than an item is in.
        - Examples: 'Dresser', 'First Aid Kit', 'Tool Box', 'Top Left Drawer'
    - **Name**: This is the name of the item itself.
        - This name is unique in it's container.
            - Entering a duplicate name will overwrite the existing item.
        - Ideally this name should be thorough and descriptive to make searching easier.
        - Examples: 'XYZ College Sweatshirt', 'XYZ Brand Adhesive Bandages', 'Orange Ratchet Screwdriver', '2012 City Phonebook'
    - **Description**: This field is optional, and contains a description of the item.
        - If you have any special notes about the nature of an item or it's location, you can put those notes here to make the item easier to locate later.
        - Examples: "Located in the green envelope", "Bright blue with orange accents", "Tucked in the back corner under other items"
    - **Indentifier**: This field is optional, and holds an identifier for a paricular item. 
        - This field is useful for manufactured items like machine parts and electronics.
        - This can be a barcode number, model number, or similar identifier that makes identifying the exact nature of an item much easier, should you need to replace it or share information about it.
    - **Quantity**: This field contains the quantity of a particular item.
        - If you don't care about measuring the quantity of an item, just put '1'.
    - **Value**: This field contains the approximate value of an individual item.
        - If you don't care about measuring the value of an item, just put '0'.
3. Press 'Add Item'


### Modifying Items

Note: It is not possible to change the name of an item by editing it. Instead, use the 'Move Item' tool for this process. If you try to edit the name of an item while editing it, a second item will be created using the new name.

1. Locate the item you want to modify.
2. Click the 'Edit' button to autofill the item's values in the item form at the top of the page.
3. Enter any updated information as desired.
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
    2. Search Items
        - The Search Items tool allows you to quickly find items in the database based on a search term.
        - The most likely search results are displayed at the top, with their name, location, and "difference score".
            - The higher the difference score, the less likely the result is to match. Lower scores indicate a more likely match.
                - Items will be assigned an intial difference score based on how many characters would have to be added, removed, or changed to match the search term.
                - Items names with words that match words in the search term will have their difference score decreased.
                - Items names with sections that match words in the entire search term will have their difference score dramatically decreased.
        - The 'Link' button will directly link to the location of the item on the main page to make editing or deleting quick and easy.
        - The number of displayed results can be customized in the configuration.
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
    3. Backup Database
        - This tool allows you to backup the item database directly on the server.
        - Simply enter a directory path and a file name to backup the complete item database.
        - It should be noted that this tool backs up the database on the server itself, not the client device. For security reasons, the database backup can't be automatically restored.
