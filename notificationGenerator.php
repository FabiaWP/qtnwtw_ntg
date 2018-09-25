<?php

include("utils/cptGenerator.php");
include("utils/retrieveUsersWithId.php");

add_action( 'init', 'notificationFormSubmit');


function generateNotification(){

    $usersList=retrieveUsersWithId();

    ?>
    <div class="wrap">
        <h2>Crea una nuova notifica</h2>
    </div>

    <form method="post" action="" class="notificationGeneratorForm" autocomplete="off">
        <p>Titolo della notifica    :  </p>
        <input type="text"        name="notificationTitle"   placeholder="Inserisci il titolo della notifica"    required /> </input>
        <p>Testo della notifica    :  </p>
        <textarea                 name="notificationContent" placeholder="Inserisci il contenuto della notifica" required /> </textarea>
        <p>Data di invio della notifica    :  </p>           <input type="text" id="datepicker" name="scheduledDate">
        <p>Utenti a cui inviare la notifica:  </p>
        <select                   data-placeholder="Cerca utenti..." name="usersList[]" class="chosen" multiple style="width:400px;">
            <?php
            foreach ($usersList as $user) {
                $user_info     = get_userdata($user->user_id);
                $user_nicename = $user_info->user_nicename;
                ?>
                <option value="<?php echo $user->user_id; ?>"><?php echo $user_nicename; ?></option>
                <?php
            }
            ?>
        </select>
        <input type="submit" name="submitbtn" value="INVIA LA NOTIFICA" /> </input>
    </form>
    <?php
}

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
    $err = curl_error($curl);

    // CLOSE CONNECTION
    curl_close($curl);

    // CHECK FOR ERRORS
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {

    };
}

function generateWarningPage(){

    ?>
    <div class="wrap">
        <h2>Attenzione!</h2>
    </div>

    <div class="wrap">
        <h3>Sembra che il plugin di OneSignal sia stato disattivato. Contattare il supporto.</h3>
    </div>


    <?php
}
