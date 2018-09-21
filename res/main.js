jQuery(document).ready(function($) {

alert('plugin per generare le notifiche attivo');

 $.ajax({
        url : setNotification.ajax_url,
    data: {
           'action': 'setNotification',
       },
        success: function( data ) {

            console.log(data);}
        });
    });;
