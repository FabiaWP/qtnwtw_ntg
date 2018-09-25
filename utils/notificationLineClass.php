<?php
    class notificationLine
    {
    function retrieveUsersList($notificationWPId)
    {
        $usersList=get_post_meta($notificationWPId,'usersList',true);
        foreach($usersList as $user)
        {   $userInfo     = get_userdata($user);
            $userNicename = $userInfo->user_nicename;
            $string=$string.$userNicename.'<br>';
        }
        return $string;

    }
    function retrieveAdditionalInfos($notificationWPId)
    {
        return get_post_meta($notificationWPId,'additionalInfo',true)[0];
    }

    function retrieveOneSignalID($notificationWPId)
    {
        return get_post_meta($notificationWPId,'oneSignalID',true);
    }
    }
