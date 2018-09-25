<?php

function retrieveSentNotifications(){


        $onesignal_wp_settings = OneSignal::get_onesignal_settings();
        $header =array(
            'authorization: Basic '.$onesignal_wp_settings['app_rest_api_key'] ,
            'content-type: application/json',
        );
        $curl = curl_init();

        // SEND REQUEST TO ONESIGNAL
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://onesignal.com/api/v1/notifications?app_id=".$onesignal_wp_settings['app_id']."&limit=5&offset=0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        $err      = curl_error($curl);

        // CLOSE CONNECTION
        curl_close($curl);

        // CHECK FOR ERRORS
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        };
}
