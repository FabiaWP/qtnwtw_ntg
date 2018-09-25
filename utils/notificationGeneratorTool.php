<?php

function notificationFormSubmit() {

    if( isset( $_POST['submitbtn'] ) ) {
        $usersList     =$_POST['usersList'];
        $scheduledDate =$_POST['scheduledDate'];
        $current_user = wp_get_current_user();

        $newWPNotification = array(
            'post_type'     => 'notification',
            'post_title'    => $_POST['notificationTitle'],
            'post_content'  => $_POST['notificationContent'],
            'post_status'   => 'publish',
            'post_author'   => $current_user->ID,
        );
        // Insert the notification into the database.
        $newWPNotificationId=wp_insert_post( $newWPNotification );
        if($newWPNotificationId!=0){
            add_post_meta($newWPNotificationId,'usersList'    ,$usersList);
            add_post_meta($newWPNotificationId,'scheduledDate',$scheduledDate);
            createOneSignalNotification($newWPNotificationId);
        }
    }
}

function createOneSignalNotification($notificationWPId){

    $players       = array();
    $usersList     = array();
    $scheduledDate = array();
    $usersList     = get_post_meta($notificationWPId,'usersList',true);
    $scheduledDate = get_post_meta($notificationWPId,'scheduledDate',true);


    foreach($usersList as $user) {
        $array = get_user_meta($user, 'onesignal_id');
        if (!empty($array)) {
            foreach ($array as $v) {
                array_push($players, $v);
            }
        }
    }


    $onesignal_wp_settings = OneSignal::get_onesignal_settings();
    $header =array(
        'authorization: Basic '.$onesignal_wp_settings['app_rest_api_key'] ,
        'content-type: application/json',
    );
    $curl = curl_init();

    $notificationContent    = get_post($notificationWPId);
    $OSnotificationContent  = $notificationContent->post_content;


    // CREATE BODY
    $body = array(
        'app_id' => $onesignal_wp_settings['app_id'] ,
        'headings' => array(
            'en' => get_the_title($notificationWPId),
            'it' => get_the_title($notificationWPId),
        ),
        'contents' => array(
            'en' => $OSnotificationContent,
            'it' => $OSnotificationContent,
        ),
        'include_player_ids' => $players,
        'send_after' => $scheduledDate,
    );


    // SEND REQUEST TO ONESIGNAL
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => $header,
    ));
    $response = curl_exec($curl);
    $err      = curl_error($curl);

    // CLOSE CONNECTION
    curl_close($curl);

    // CHECK FOR ERRORS
    if ($err) {
        echo "cURL Error #:" . $err;
        update_post_meta($notificationWPId,'additionalInfo', 'Attenzione:errore!');

    } else {
        $decodedResponse=json_decode($response);
        if($decodedResponse->id){
        update_post_meta($notificationWPId,'oneSignalID',$decodedResponse->id);
        }
        else{
        update_post_meta($notificationWPId,'additionalInfo',$decodedResponse->errors);
        }
    };
}
