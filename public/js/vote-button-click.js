$(document).ready(function(){
    $('.vote-button').on('click', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();

        var route = $(this).data('target');
        var data = {
            _token:$(this).data('token'),
            testdata: 'testdatacontent'
        };

        var handle = $(this);
        var type = $(this).data('type') == 'upvote' ? 'upvote' : 'downvote';
        var siblingType = $(this).data('type') == 'upvote' ? 'downvote' : 'upvote';


        $.post( route, function( data ) {
            console.log(data);
            console.log(handle.data('target'));
            console.log(handle.data('identification'));
            console.log(siblingType);
            handle.children('span').each(function(){
                $(this).text('  '+data.data1+' ');
            });
            $('#'+handle.data('identification')+'-'+siblingType).children('span').each(function(){
                $(this).text('  '+data.data2+' ');
            });
            $('#'+handle.data('identification')+'-'+siblingType).attr('disabled',false);

            handle.attr('disabled', true);
            handle.addClass(type);
        });
    });
    $('.btn-edit').on('click', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();
        var route = $(this).data('target');

        $.post( route, function( data ) {

        });
    });
});

