$('#notificationsMarkViewed').click(function(e){
    e.preventDefault()
    console.log('dupa');
    var route = '/notifications/viewAll';
    $.post( route, function( data ) {
        $('#notifications-li').find("div").removeClass("notification-unread");
        $('#notifications-count').text(' ');
    });
});
//$('a.dropdown-toggle').on('click', function (event) {
//    $(this).parent().toggleClass('open');
//});
