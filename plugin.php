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

        //add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 999, 1);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 999, 1);

    }
    function enqueue_scripts()
    {

        wp_register_style('twr-not-generator', plugins_url().'/'.basename(TWR_TNG). '/res/style.css');
        wp_enqueue_style( 'twr-not-generator');
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

add_action( 'wp_ajax_nopriv_setNotification', 'setNotification' );
add_action( 'wp_ajax_setNotification'       , 'setNotification' );

function setNotification(){

    wp_send_json($return);
}
