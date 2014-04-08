### account_timezone

The account_timezone module allow users to set `date_default_timezone` (language) per account. 
This will override default timezone when user is logged in.

### Usage

The module will work as a `sub module` to e.g. a profile module. In the default setup
I use the 'profile' module `account_profile` (where user can write a short bio and enter birthday and a few other things). 
The `account_timezone` module needs a single ini setting, which will tell which module
is the parent module:

     account_timezone_parent = 'account_profile'

In the `account_profile` module I have added the following to the `account_profile.ini` file

    account_profile_events[] = 'account_timezone::events'

This will ensure that `account_timezone::events` is called in the `account_profile` 
module. All it does is to attach a `Locales` menu item to the `account_profile` module menu

This makes it easier to attach `account_locales` to any  `account profile` module.  

### Call example

The event is called inside the `menu.inc` file of `account_profile` module: 

    $events = config::getModuleIni('account_profile_events');
    $args = array (
        'action' => 'attach_module_menu',
    );

    $menus = event::getTriggerEvent($events, $args);    
    foreach($menus as $menu) {
        $_MODULE_MENU[] = $menu;
    } 

You will need something similar if you write your own account profile system.
