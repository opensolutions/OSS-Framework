//****************************************************************************
// Chosen Functions
//****************************************************************************

$( 'document' ).ready( function(){
    $(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({allow_single_deselect:true});
});

// clear a chosen dropdown
function ossChosenClear( id ) {
    $( id ).html( "" ).val( "" );
    $( id ).trigger( "liszt:updated" );
}

//clear a chosen dropdown with a placeholder
function ossChosenClear( id, ph ) {
    $( id ).html( ph ).val( "" );
    $( id ).trigger( "liszt:updated" );
}


// set a chosen dropdown
function ossChosenSet( id, options, value ) {
    $( id ).html( options );

    if( value != undefined )
    	$( id ).val( value );

    $( id ).trigger( "liszt:updated" );
}

