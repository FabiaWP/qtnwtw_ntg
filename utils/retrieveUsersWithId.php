<?php

function retrieveUsersWithId(){

    global $wpdb;
    $usersWithId = $wpdb->get_results( "SELECT DISTINCT user_id FROM `wp_usermeta` WHERE `meta_key` LIKE 'onesignal_id' ORDER BY `user_id` DESC");
    return $usersWithId;
}

 ?>
