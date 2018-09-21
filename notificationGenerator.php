<?php

class notification {
    var $date;
    public function __construct() {
    }
    public function get_date() {
        return $this->date;
    }
    public function set_date($new_date) {
        $this->date = $new_date;
    }
    public function calculateAge(){
        return date('Y')- date('Y', strtotime($this->get_date()));
    }
}



function generateNotification(){


    ?>
    <div class="wrap">
        <h2>Crea una nuova notifica</h2>
    </div>


    <?php



}
?>
