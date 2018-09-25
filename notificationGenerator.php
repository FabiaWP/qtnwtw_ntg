<?php

include("utils/cptGenerator.php");
include("utils/retrieveUsersWithId.php");
include("utils/notificationGeneratorTool.php");

add_action( 'init', 'notificationFormSubmit');


function generateNotificationForm(){

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
