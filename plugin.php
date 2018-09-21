<?php

/*
Plugin Name: Twr Notification Generator (TNG)
Description: Notification Generator (TNG)
Author: Touchware
*/


define('TWR_TNG', dirname(__FILE__));
define('TWR_TNG_BASENAME', basename(TWR_TNG));
define('TWR_TNG_URL', plugins_url() . '/' . TWR_TNG);


include("notificationGenerator.php");

class TWR_TNG
{
    /**
    *  constructor.
    */
    public function __construct()
    {

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 999, 1);

    }
    function enqueue_scripts()
    {
    }
}

new TWR_TNG();


add_action('admin_menu', 'global_notification_generator');

function global_notification_generator()
{
    add_users_page('Generatore di notifiche', 'Generatore di notifiche', 'manage_options', 'generate_notification','generate_notification_page');
}

function generate_notification_page(){
    return generateNotification();
}