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
        <input type="submit"     name="submitbtn"           value="INVIA LA NOTIFICA" /> </input>
    </form>

    <style>

    textarea{
    width: 50%;    

    }
    input[type=text], select {
    width: 50%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;}

    input[type=submit] {
    width: 50%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;    cursor: pointer; }

    input[type=submit]:hover {
    background-color: #45a049; }

</style>

    <?php
}

add_action( 'init', 'notificationFormSubmit');

function notificationFormSubmit() {
    if( isset( $_POST['submitbtn'] ) ) {

    // Gather post data.
    $my_post = array(
    'post_type'     => 'notification',
    'post_title'    => $_POST['notificationTitle'],
    'post_content'  => $_POST['notificationContent'],
    'post_status'   => 'publish',
    'post_author'   => 1,

     );

     // Insert the post into the database.
     wp_insert_post( $my_post );
    }
}
