$(document).ready(function(){
    $('.vote-button').on('click', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();

        var route = $(this).data('target'),
            sortableID = $(this).attr('data-sortable-id');
        var data = {
            _token:$(this).data('token'),
            testdata: 'testdatacontent'
        }
        $.post( route, function( data ) {
            console.log( data );
        });
    });
    $('.btn-edit').on('click', function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();
        var route = $(this).data('target');


        $.post( route, function( data ) {
            console.log( data );
        });
    });
});

