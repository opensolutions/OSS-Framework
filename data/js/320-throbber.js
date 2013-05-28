//****************************************************************************
// Throbber Functions
//****************************************************************************

/**
 * This function creates throbber with some default parameters and return the throbber object.
 *
 * @param size  This is size of throbber in pixels.
 * @param lines This is lines count, defines how many lines per throbber.
 * @param strokewidth This is the widh of line.
 * @param fallback This is path to alternative throbber image if browser not compatible with this one.
 * @return Throbber The throbber object
 */

function ossThrobber( size, lines, strokewidth, fallback )
{
    if( !fallback )
        fallback = 'images/throbber_32px.gif';

    return new Throbber({
        "color": 'black',
        "size": size,
        "fade": 750,
        "fallback": fallback,
        "rotationspeed": 0,
        "lines": lines,
        "strokewidth": strokewidth,
        "alpha": 1
    });
}

/**
 * This function creates throbber with overlay on element found by selector
 *
 * @param size  This is size of throbber in pixels.
 * @param lines This is lines count, defines how many lines per throbber.
 * @param strokewidth This is the widh of line.
 * @param fallback This is path to alternative throbber image if browser not compatible with this one.
 * @return Throbber The throbber object
 */

function ossThrobberWithOverlay( size, lines, strokewidth, selector, fallback )
{
    if( !fallback )
        fallback = '../images/throbber_32px.gif';

    var Throb = new Throbber({
        "color": 'white',
        "size": size,
        "fade": 500, 
        "fallback": fallback,
        "rotationspeed": 0,  
        "lines": lines,
        "strokewidth": strokewidth,
        "alpha": 1
    });

    $( selector ).prepend( '<div id="overlay" align="center" valign="middle" style="margin: -12px;"  class="oss-overlay hide"></div>' );

    var height = $( selector ).height();
    var padding = ( height - size ) / 2;

    $("#overlay").css( 'padding-top', padding );

    $("#overlay").height( $( selector ).height() + 23 - padding  ).width( $( selector ).width() + 23 );
    $("#overlay").fadeIn( "slow" );
    
    Throb.appendTo( $( '#overlay' ).get(0) ).start();

    return Throb;
}

