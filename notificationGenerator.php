<?php

// Our custom post type function
function create_posttype() {

    register_post_type( 'notification',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Notifications' ),
                'singular_name' => __( 'Notification' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'notifications'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

function generateNotification(){


    ?>
    <div class="wrap">
        <h2>Crea una nuova notifica</h2>
    </div>

    <form method="post" action="" class="notificationGeneratorForm">
        <input type="text"       name="notificationTitle"   placeholder="Inserisci qui il titolo della notifica"    required /> </input>
        <textarea                name="notificationContent" placeholder="Inserisci qui il contenuto della notifica" required /> </textarea>
        <select                  data-placeholder="Cerca utenti..." name="users[]" class="chosen" multiple style="width:400px;">
            <option value="1">admin</option>
            <option value="2">pepe</option>
            <option value="3">pippo</option>
        </select>


        <script src="../wp-content/plugins/twr-not-generator/res/chosen.js"></script>
        <script type="text/javascript">
        $(".chosen").chosen({allow_single_deselect: true});
        </script>

        <input type="submit"     name="submitbtn"           value="INVIA LA NOTIFICA" /> </input>
    </form>




    <?php
}

add_action( 'init', 'notificationFormSubmit');

function notificationFormSubmit() {
    if( isset( $_POST['submitbtn'] ) ) {

    // Gather post data.
    $my_post = array(
    'post_type'     => 'notification',
    'post_title'    => $_POST['notificationTitle'],
    'post_content'  => $_POST['notificationContent'].count($_POST['users']),
    'post_status'   => 'publish',
    'post_author'   => 1,

     );

     // Insert the post into the database.
     wp_insert_post( $my_post );
    }
}
