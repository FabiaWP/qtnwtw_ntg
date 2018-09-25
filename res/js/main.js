jQuery(document).ready(function($) {

$(".chosen").chosen({allow_single_deselect: true});

$("#datepicker").datetimepicker({ minDate:0, dateFormat: 'dd-mm-yy' });


// var button = document.getElementById('generateNotification');
// button.addEventListener('click', function() {
//  $.ajax({
//         url : setNotification.ajax_url,
//     data: {
//            'action': 'setNotification',
//        },
//         success: function( data ) {
//
//             alert(data);
//         }
//         });
// });
});
