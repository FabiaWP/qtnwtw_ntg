<?php

/*
Plugin Name: Twr Notification Generator (TNG)
Description: Notification Generator (TNG)
Author: Touchware
Version:2.0.1
*/


define('TWR_TNG', dirname(__FILE__));
define('TWR_TNG_BASENAME', basename(TWR_TNG));
define('TWR_TNG_URL', plugins_url() . '/' . TWR_TNG);


include("notificationGenerator.php");
include("notificationArchive.php");

class TWR_TNG
{
    /**
     *  constructor.
     */
    public function __construct()
    {

        add_action('admin_enqueue_scripts', array(
            $this,
            'enqueue_scripts'
        ), 999, 1);


    }
    function enqueue_scripts()
    {

        wp_register_style('twr-not-generator', plugins_url() . '/' . basename(TWR_TNG) . '/res/style.css');
        wp_enqueue_style('twr-not-generator');
        wp_register_style('twr-date-time-picker', plugins_url() . '/' . basename(TWR_TNG) . '/res/datetimepickerstyle.min.css');
        wp_enqueue_style('twr-date-time-picker');
        wp_register_script('twr-chosen', plugins_url() . '/' . basename(TWR_TNG) . '/res/js/chosen.js');
        wp_enqueue_script('twr-chosen');
        wp_register_script('twr-date-time-picker-js', plugins_url() . '/' . basename(TWR_TNG) . '/res/js/datetimepicker.js');
        wp_enqueue_script('twr-date-time-picker-js');
        wp_register_script('twr-main', plugins_url() . '/' . basename(TWR_TNG) . '/res/js/main.js');
        wp_enqueue_script('twr-main');


    }
}

new TWR_TNG();


add_action('admin_menu', 'global_notification_generator');

function global_notification_generator()
{
    add_options_page('Generatore di notifiche', 'Generatore di notifiche', 'manage_options', 'generate_notification', 'generate_notification_page');
    add_options_page('Archivio delle notifiche', 'Archivio delle notifiche', 'manage_options', 'archive_notification','archive_notification_page');
}

function generate_notification_page()
{
    if (is_plugin_active('onesignal-free-web-push-notifications/onesignal.php')) {
        return generateNotificationForm();
    } else {
        return generateWarningPage();
    }
}

function archive_notification_page()
{   return generateNotificationArchive();
}

add_action('wp_ajax_nopriv_setNotification', 'setNotification');
add_action('wp_ajax_setNotification', 'setNotification');

function setNotification()
{
        wp_send_json($return);
}
