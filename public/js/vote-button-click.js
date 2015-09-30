$(document).ready(function(){
    $('.vote-button').on('click', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();

        var route = $(this).data('method');

        var handle = $(this);
        var type = $(this).data('type') == 'upvote' ? 'upvote' : 'downvote';
        var siblingType = $(this).data('type') == 'upvote' ? 'downvote' : 'upvote';

        $.post( route, function( data ) {
            console.log(data);
            console.log(handle.data('method'));
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
        var route = $(this).data('method');

        $.post( route, function( data ) {

        });
    });
    $('.btn-delete').on('click', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();
        var route = $(this).data('method');
        var id = $(this).data('identification');
        console.log(id);
        $('#alertModalConfirm').attr('data-method',route)
        $('#alertModalConfirm').attr('data-identification',id);
        console.log(route);
        $('#alertModal').modal('show');

    });
    $('#alertModalConfirm').on('click',function(e){
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();
        console.log('dupa');
        var route = $(this).data('method');
        var container = $(this).data('identification')+"-container";
        $.post( route, function( data ) {
            $('#alertModal').modal('hide');
            $('.post-container').remove('#'+container);
        });
    });
});

