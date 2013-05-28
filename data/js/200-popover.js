//****************************************************************************
// Popover Functions
//****************************************************************************

$( 'document' ).ready( function(){

    // Activate Bootstrap pop ups
    $("[rel=popover]").popover(
        {
            offset: 10,
            html: true,
            trigger: "hover"
        }
    );

    $( "[data-oss-po-content]" ).each( ossPopover );
});


/**
 * This function is used on each method with selector [data-oss-po-content] which means
 * all DOM elements with attribute data-oss-po-content
 *
 * Attributes to configure popover:
 *    data-oss-po-content - mandatory and initial attribute. Sets popover text.
 *    data-oss-po-title - sets title for popover. Default is false.
 *    data-oss-po-placement - sets placement for popover. Default is top. Valid options: [top, bottom, left, right]
 *    data-oss-po-delay - sets delay in ms for popover show and hide. Default is 0.
 *    data-oss-po-trigger - sets trigger hook. Default is click. Valid options: [click, hover, focus, manual]
 *    data-oss-po-animation - turns animation on or off. Default is true. Valid options: [true, false]
 */
function ossPopover()
{
    var id = $( this ).attr( "id" );
    var prefix = "data-oss-po-";

    if( $( this ).attr( 'type' ) == "checkbox" )
    {
        $( this ).closest( 'label' ).append('<span id="' + id + '_pop_info" style="padding: 2px 0px 0px 5px;"><i class="icon-info-sign"></span>');
        $( '#' + id + '_pop_info' ).on( "click", function( event ){
            event.preventDefault();
        });
        $( '#' + id + '_pop_info' ).on( "mousedown", function( event ){
            event.preventDefault();
        });
    }
    else if( $( this ).parent().attr( "class" ).indexOf( "input-append" ) != -1 )
        $( this ).parent().after('<span id="' + id + '_pop_info" style="padding: 2px 0px 0px 5px;"><i class="icon-info-sign"></span>');
    else
        $( this ).closest( '.controls' ).append('<span id="' + id + '_pop_info" style="padding: 2px 0px 0px 5px;"><i class="icon-info-sign"></span>');

    $( "#" + id + "_pop_info" ).popover({
        content:   $( this ).attr( prefix + "content" ),
        html:      true,
        trigger:   $( this ).attr( prefix + "trigger" ) ? $( this ).attr( prefix + "trigger" ) :'click',
        title:     $( this ).attr( prefix + "title" ) ? $( this ).attr( prefix + "title" ) : false,
        delay:     $( this ).attr( prefix + "delay" ) ? parseInt( $( this ).attr( prefix + "delay" ) ) : 0,
        animation: $( this ).attr( prefix + "animation" ) ? $( this ).attr( prefix + "animation" ) : true,
        placement: $( this ).attr( prefix + "placement" ) ? $( this ).attr( prefix + "placement" ) : 'top'

    });
}

