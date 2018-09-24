<?php

include("utils/cptGenerator.php");
include("utils/retrieveUsersWithId.php");

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


        <script src="../wp-content/plugins/twr-not-generator/res/js/chosen.js"></script>
        <script src="../wp-content/plugins/twr-not-generator/res/js/datetimepicker.js"></script>
        <script type="text/javascript">
        $(".chosen").chosen({allow_single_deselect: true});
        </script>
        <script>
        $( function() {
            $( "#datepicker" ).datetimepicker({ minDate:0, dateFormat: 'dd-mm-yy' });
        } );
        </script>
        <input type="submit" name="submitbtn" value="INVIA LA NOTIFICA" /> </input>
    </form>
    <?php
}

add_action( 'init', 'notificationFormSubmit');

function notificationFormSubmit() {

    if( isset( $_POST['submitbtn'] ) ) {
        echo 'La notifica è stata inserita correttamente.';
        $usersList     =$_POST['usersList'];
        $scheduledDate =$_POST['scheduledDate'];
        $current_user = wp_get_current_user();

        $my_post = array(
            'post_type'     => 'notification',
            'post_title'    => $_POST['notificationTitle'],
            'post_content'  => $_POST['notificationContent'],
            'post_status'   => 'publish',
            'post_author'   => $current_user->ID,
        );
        // Insert the notification into the database.
        $postId=wp_insert_post( $my_post );
        if($postId!=0){
            update_post_meta($postId,'usersList'    ,$usersList);
            update_post_meta($postId,'scheduledDate',$scheduledDate);
        }
    }
}
