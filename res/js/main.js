jQuery(document).ready(function($) {


var button = document.getElementById('generateNotification');
button.addEventListener('click', function() {
 $.ajax({
        url : setNotification.ajax_url,
    data: {
           'action': 'setNotification',
       },
        success: function( data ) {

            alert(data);
        }
        });
});
});
