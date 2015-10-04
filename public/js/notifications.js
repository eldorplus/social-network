$('#notificationsMarkViewed').click(function(e){
    e.preventDefault()
    console.log('dupa');
    var route = '/notifications/viewAll';
    $.post( route, function( data ) {
        $('#notifications-li').children().each(function(){
            console.log(this);
        })
    });
});