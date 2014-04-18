<?php

/**
 * file contains account_timezone
 */

/**
 * class account_locales
 */
class account_timezone {
    
    /**
     * events: attach the account_locales module to a parent module
     * @param type $args
     * @return type
     */
    public static function events ($args) {
        if ($args['action'] == 'attach_module_menu') {
            return self::getModuleMenuItem($args);
        }
    }
    
    /**
     * create a module menu item for setting locales per account
     * @param array $args
     * @return array $menu menu item
     */
    public static function getModuleMenuItem ($args) {
        $ary = array(
            'title' => lang::translate('Edit timezone'),
            'url' => '/account_timezone/edit',
            'auth' => 'user');
        return $ary;
    }
    
    /**
     * use locales language form and set 'account_locales_language', user_id 
     * in system_cache
     */
    public static function editAction () {
        
        if (!session::checkAccess('user')) {
            return;
        }
        
        moduleloader::includeModule('locales'); 
        echo locales_views::timezoneInfo();
        
        $parent = config::getModuleIni('account_timezone_parent');        
        layout::setParentModuleMenu($parent);
        
        if (isset($_POST['timezone'])) {
            locales::updateAccountTimezone('/account_timezone/edit');
        }

        $default = config::getMainIni('date_default_timezone');
        $user_language = cache::get('account_timezone', session::getUserId());
        if ($user_language) {
            $default = $user_language;
        }
        locales::setTimezoneForm($default);       
    }
}

