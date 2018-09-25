<?php

include("utils/retrieveSavedNotifications.php");
include("utils/retrieveSentNotifications.php");
include("utils/notificationLineClass.php");

function generateNotificationArchive(){

    $notificationsList=array();
    $notificationsList=retrieveSavedNotifications();
    ?>
    <div id ="twr-notification-table">
        <div class="wrap">
            <h2>Storico delle notifiche salvate.</h2>
            <h4>In questa tabella vengono visualizzate le ultime #n notifiche salvate. </h4>
        </div>

        <table >
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Titolo</th>
                    <th>Contenuto</th>
                    <th>Destinatari</th>
                    <th>Errori</th>
                    <th>One Signal ID</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($notificationsList as $notification) {
                    $notificationLine = new notificationLine;
                    echo '<tr>
                    <td>'.$notification->post_date.'</td>
                    <td>'.$notification->post_title.'</td>
                    <td>'.$notification->post_content.'</td>
                    <td>'.$notificationLine->retrieveUsersList      ($notification->ID).'</td>
                    <td>'.$notificationLine->retrieveAdditionalInfos($notification->ID).'</td>
                    <td>'.$notificationLine->retrieveOneSignalID    ($notification->ID).'</td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>

        <div class="wrap">
            <h2>Storico delle notifiche inviate.</h2>
            <h4>In questa tabella vengono visualizzate le ultime #n notifiche inviate da OneSignal </h4>
        </div>

        <?php

        $OSNotificationsComplete=json_decode(retrieveSentNotifications());
        $OSnotificationsList=$OSNotificationsComplete->notifications;

        ?>

        <table >
            <thead>
                <tr>
                    <th>One Signal ID</th>
                    <th>Titolo</th>
                    <th>Contenuto</th>
                    <th>Cancellata</th>
                    <th>Errori</th>

                </tr>
            </thead>
            <tbody>
<?php

                foreach ($OSnotificationsList as $notification) {
                    $notificationLine = new notificationLine;
                    echo '<tr>
                    <td>'.$notification->id.'</td>
                    <td>'.$notification->headings->en.'</td>
                    <td>'.$notification->contents->en.'</td>
                    <td>'.$notification->canceled.'</td>
                    <td>Prova</td>

                    </tr>';
                }
                ?>
            </tbody>
        </table>



    </div>
    <?php
}
