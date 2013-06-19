//****************************************************************************
// Chosen Functions
//****************************************************************************

$( 'document' ).ready( function(){

    $(".chzn-select").each( function( index ){
        $( this ).chosen();
        ossChosenFixWidth( $( this ) );
    });
    
    $(".chzn-select-deselect").each( function( index ) {
        $( this ).chosen( { allow_single_deselect:true } );
        ossChosenFixWidth( $( this ) );
    });
});


//See https://github.com/harvesthq/chosen/issues/92 for:
function ossChosenFixWidth( obj, force ) {
    if( ( force != undefined && force == true ) || obj.attr( 'chzn-fix-width' ) === '1' ) {
        czn_id = "#" + obj.attr( "id" ) + "_chzn";
        width = parseInt( obj.css( "width" ) );
        
        if( $( czn_id ).length == 0)
            czn_id = czn_id.replace( /\-/g, "_" );
        
        $( czn_id ).css( "width", width + "px" );
    }
}

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

