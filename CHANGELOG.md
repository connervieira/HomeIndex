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

*Release date to be determined*

- Multiple users can now share a single instance.
- Improved authentication system.
    - All pages now load the same authentication script.
        - This makes bugs far less likely to go unnoticed.
    - Users can now be granted access without being given full administration abilities.
- Improved database system.
    - All pages now load the same database script.
        - This makes bugs far less likely to go unnoticed.
- Added a check to prevent the search tool from malfunctioning if the item database is empty.
