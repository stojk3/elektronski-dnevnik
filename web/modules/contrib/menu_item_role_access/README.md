# Menu Item Role Access

Provides a the ability to restrict access to menu items by the users role

- For a full description of the module, visit the
  [project page](https://www.drupal.org/project/menu_item_role_access).

- To submit bug reports or feature suggestions, or track changes
  [issue queue](https://www.drupal.org/project/issues/menu_item_role_access).


## Table of contents

- Requirements
- Installation
- Configuration
- Maintainers


## Requirements

This module requires the following modules to be installed:

 - menu_link_content
 - menu_ui

## Installation

Install as you would normally install a contributed Drupal module. Visit
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules)
for further information.

## Configuration

 - Go to the menu item you wish to restrict within the admin UI and select the
   roles which should have access to the menu item.
 - Configuration options for the way menu_item_role_access behaves can be found
   at admin/config/menu-item-role-access

## Troubleshooting

- Trouble:
  - User see menu item, but his role not allowed for this menu item.
  - User don't see menu item, but his role allowed for this menu item.

- Fix:
  By default, Drupal permissions are used (/admin/people/permissions).
 This mean that menu item will be displayed for role that have view permissions,
 even if you set a limit for this menu item in "Menu Item Role".
 Also, the menu item will not be shown,
 if the role does not have a Drupal permissions to view menu item.

- To fix this:
  - Navigate to admin/config/menu-item-role-access and press,
 "Overwrite internal link target access check".
  - Clear the cache.
  - Enjoy.

## Maintainers

Current maintainers:
 * Liam Hiscock - [LiamPower](https://www.drupal.org/u/liampower)
