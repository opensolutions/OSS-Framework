//****************************************************************************
// Tooltip Functions
//****************************************************************************

$( 'document' ).ready( function(){
    $("[rel=tooltip]").tooltip();
    $( '.have-tooltip' ).tooltip( { html: true, delay: { show: 500, hide: 2 }, trigger: 'hover' } );
    $( '.have-tooltip-below' ).tooltip( { html: true, delay: { show: 500, hide: 2 }, trigger: 'hover', placement: 'bottom' } );
    $( '.have-tooltip-long' ).tooltip( { html: true, trigger: 'hover', placement: 'top' } );
});

