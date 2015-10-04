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
    $('.btn-edit').on('click', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        var id = $(this).data('identification');

        if($(this).data('editing')==false){ //if user wants to edit post
             var p = $('#'+id+'-content');
            p.replaceWith($("<textarea/>", {
                "class": "edit",
                "text": p.text().replace("\n", "").replace(/\s{2,}/g, " ").trim(),
                "css": { "width": p.css('width') },
                "id": id+"-textarea"
            }));
            var save = $("<button/>",{
                "class"                 : "btn btn-primary btn-save-edit",
                "text"                  : "Save",
                "data-identification"   : id,
                "click"                 : save_changes
            });
            var cancel = $("<button/>",{
                "class"                 : "btn btn-primary btn-dismiss-edit",
                "text"                  : "Cancel",
                "data-identification"   : id,
                "click"                 : dismiss_changes
            });
            $('#'+id+'-edit-controls').append(cancel).end();
            $('#'+id+'-edit-controls').append(save).end();

            $(this).data('editing',true);
        }
    });
    function dismiss_changes(e){
        e.stopImmediatePropagation();
        e.preventDefault();
        var id = $(this).data('identification');
        var textarea = $('#'+id+"-textarea");
        textarea.replaceWith($("<p/>",{
            "text"  : textarea.text(),
            "id"    : id+"-content"
        }));
        $('#'+id+'-edit-controls').empty();
        $('#'+id+'-edit').data('editing',false);
    };
    function save_changes(e){
        e.stopImmediatePropagation();
        e.preventDefault();
        var id = $(this).data('identification');
        var route = '/post/'+id+'/edit';
        console.log(route);
        //TODO zapis zmian
        //$.post( route, function( data ) {
        //
        //});
    }
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

