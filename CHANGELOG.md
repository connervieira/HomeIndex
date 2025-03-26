# Changelog

This document contains a list of all the changes for each version of Home Index.


## Version 1.0

### Initial Release

October 12th, 2022

- Core functionality
    - Item adding and deletion
    - Basic configuration
    - Interface themes


## Version 2.0

### Conveinence Update

This update adds several features that make Home Index an even more powerful tool to make your life easier. Improved editing, searching, and styling makes it even quicker to index your possessions.

November 7th, 2022

- Improved editing process.
    - Locations, spaces, containers, and items can now be clicked to automatically fill their values into the item adding form.
- Improved styling.
    - Buttons now appear more consistent and recognizable.
    - The darker theme contains darker form elements.
    - Forms now use more mobile-friendly layouts and styles with bigger touch points.
- Added several new tools.
    - Added plain text item listing tool.
    - Added item searching tool.
    - Added a direct item database backup tool.
    - Added support for object moving and renaming.
        - Added container renaming and moving tool.
        - Added item renaming and moving tool.
- Separated the database organization process into a separate script that is run every time the main page is loaded.
- Added additional statistics to the About tool.
    - The total number of locations, spaces, and containers are now displayed along side the total item count.
    - The total value of all items in the database is now calculated and displayed.
- Added a configuration value to enable or disable the Advanced Tools section on the Tools page.


## Version 3.0

### Hosting Update

This update focuses on Home Index use on servers, and improves security and stability. Notably, this update also adds support for multiple users on a single instance.

September 12th, 2023

- Multiple users can now share a single instance.
    - Users have their own item inventory database, and can individually export their information.
    - Only the administrator user can access the entire database.
        - The administrator can also manually remove users from the item database.
    - The `migrate.php` tool allows the old database system to be migrated to the new, user based system.
    - There is now a maximum item limit, per user.
        - The global default item limit for each user can be set in the configuration by the administrator.
        - Individual limits can be set for each user separately by the administrator.
- Improved authentication system.
    - All pages now load the same authentication script.
        - This makes bugs far less likely to go unnoticed.
    - Users can now be granted access without being given full administration abilities.
- Improved database system.
    - All pages now load the same database script.
        - This makes bugs far less likely to go unnoticed.
- Added a check to prevent the search tool from malfunctioning if the item database is empty.
- Added sanitization to URL autofill values on the main page.
- Added 'identifier' field to to items.
- Improved database backups.
    - Removed unnecessary code from the database backup tool.
    - Added automatic backup functionality.
- Improved input sanitization.
    - Inputs now have a maximum length to prevent malicious users from filling the database with junk data.
    - All inputs are now sanitized, even if they are only accessible to the administrator.
- Added shortcut to move items on the main page.
- Added a privacy page explaining the privacy and security implications of using a third party instance.
- Fixed capitalization in "Name" field on the main page.


## Version 3.1

*Release date to be determined*

- Home Index now checks to make sure the user is signed in with DropAuth (or a DropAuth compliant service), rather than just checking for a username.
- Improved the reliability of the database organization process.
- Added descriptions to various input fields.
- Moved the 'rainbow' theme to the end of the list on the configuration page.
- Added container list tool
