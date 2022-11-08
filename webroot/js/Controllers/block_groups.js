function toggleBlockGroupSettings( oElement ){
    $(oElement).closest('.panel').find('.panel-body').fadeToggle();
}

function addBlockGroups( sModel, iAmount ){

    $('.block-group-add, .block-group-row').remove();

    for( var i=0; i<iAmount; i++){
        addBlockGroup(sModel, i);
    }
    if( iAmount > 0 ){
        var t = $('#amount-block-groups').closest('.panel').offset().top;
        var h = $('#amount-block-groups').closest('.panel').outerHeight();
        $('body,html').animate({ scrollTop: (t+h) }, 250);
    }
}

function addBlockGroup(sModel, i){
    $.ajax({
        url: d + '/blockGroups/add_form',
        type: 'post',
        data: {
            id: i,
            model: sModel
        }
    }).done(function(template){
        $('#block-configuration-content').append( template );
    });
}

function setBlocks(iId, oElement){

    var $parent = $(oElement).closest('.panel');
    var iAmountBlocks = $(oElement).val();

    $('#block-group-row-' + iId).remove();

    $.ajax({
        url: d + '/blockGroups/add_form_blocks',
        type: 'post',
        data: {
            id: iId,
            amount_blocks: iAmountBlocks
        }
    }).done(function(template){
        $parent.after( template );
    });
}

function closeBlockGroup(oElement){
    var $parent = $(oElement).closest('.panel');
    var parentId = $parent.data('id');
    $parent.remove();
    $('#block-group-row-'+parentId).remove();

}