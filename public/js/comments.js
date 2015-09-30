$( document ).ready( function() {
    $( '.comment-form' ).on( 'submit', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();

        var data = $(this).serializeArray();
        var body = data[1].value;
        var target = $(this).attr('action');
        var identification = $(this).attr('data-identification');

        console.log(identification);
        $.ajax({
            type: "POST",
            url: target,
            data: {body:body},
            success: function(data ) {
                $('#'+identification+'-comment-button').text('  '+data['comments-count']+' ');
                $('#'+identification+'-comments-container').prepend(
                    '<div class="row comment">'+
                        '<div class="col-xs-1" class="comment-profile-picture">'+
                            '<span align="center" class="glyphicon glyphicon-user"></span>'+
                        '</div>'+
                        '<div class="col-xs-11">'+
                            '<a href="/user/"'+data['user-id']+'>'+
                               data['user-name']+' '+data['user-surname']+
                            '</a> : '+
                            body+
                        '</div>'+
                    '</div>'
                )
                $('#'+identification+'-input').val('');
            }
        });
    });
});