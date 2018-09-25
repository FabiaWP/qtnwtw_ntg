<?php

function retrieveSavedNotifications(){

    global $wpdb;
    $savedNotifications = $wpdb->get_results( "SELECT * FROM `wp_posts` WHERE `post_status` LIKE 'publish' AND `post_type` LIKE 'notification' ORDER BY 'post_date' DESC");
    return $savedNotifications;
}
