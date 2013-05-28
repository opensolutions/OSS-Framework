//****************************************************************************
// Utility Functions
//****************************************************************************

/**
 * Sort function used in various places
 */
function ossSortByName(a, b)
{
	var aName = a.name.toLowerCase();
	var bName = b.name.toLowerCase();
	return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
}

/**
 * Set proper width and margins for bordered fieldset
 */
function ossFormatFieldset()
{
    $( ".legend-fieldset-bordered" ).css( "width", $( ".legend-fieldset-bordered > label" ).width() + 20 );
	
	$( ".fieldset-bordered-elements> .control-group > .control-label" ).each(function( index ) {
        $(this).width( "100" );
    });
	
	$( ".fieldset-bordered-elements > .control-group > .controls" ).each(function( index ) {
        $(this).css( "margin-left", "120px" );
    });
}

/**
 * This is simple ajax function where handling made in code.
 *
 * function calls AJAX for passed URL and data. If responce ok it return true
 * else it returns false.
 *
 * NOTE: asyn set to false
 *
 * @param string Url This is URL for AJAX.
 * @param Array data Data for AJAX to post.
 * @return bool
 */
function ossAjax( Url, data )
{
    var ok = false;

    $.ajax({
        url: Url,
        data: data,
        async: false,
        cache: false,
        type: 'POST',
        timeout: 10000,
        success: function( data ){
            if( data == "ok" ) {
                ok = true;
            } else {
                ossAddMessage( data, 'error' );
            }
        },
        error: ossAjaxErrorHandler
    });
    return ok;
}

/**
 * Formating date by specific format
 *
 * @param Date date The date to be formated
 * @param int format Wanted format of the date
 * @return string
 */
function ossFormatDateAsString( date, format )
{
    if( format == undefined )
        format = '1';

    var day   = ( date.getDate() < 10 ? '0' : '' ) + date.getDate();
    var month = ( date.getMonth() + 1 < 10 ? '0' : '' ) + ( date.getMonth() + 1 );

    // case values correspond to OSS_Date DF_* constants
    switch( format )
    {
        case '2': // mm/dd/yyyy
            return month + "/" + day + "/" + date.getFullYear();
            break;

        case '3': // yyyy-mm-dd
            return date.getFullYear() + "-" + month + "-" + day;
            break;

        case '4': // yyyy/mm/dd
            return date.getFullYear() + "/" + month + "/" + day;
            break;

        case '5': // yyyymmdd
            return date.getFullYear() + month + day;
            break;

        case '1': // dd/mm/yyyy
        default:
            return day + "/" + month + "/" + date.getFullYear();
            break;
    }
}

/**
 * Turn a string into a JS Date() object
 * @param str The date as dd/mm/YY
 * @return Date The date object
 */
function ossGetDate( id )
{
    dparts = ossDateSplit( id );
    return new Date( dparts[2], dparts[1] - 1, dparts[0], 0, 0, 0, 0 );
}

/**
 * Split a date into an array of day / month / year for the appropriate date format
 * @param id The date field id
 * @return array
 */
function ossDateSplit( id )
{
    var dparts = [];

    // case values correspond to OSS_Date DF_* constants
    switch( $( "#" + id ).attr( 'data-dateformat' ) )
    {
        case '2': // mm/dd/yyyy
            var t = $( "#" + id ).val().split( '/' );
            dparts[0] = t[1];
            dparts[1] = t[0];
            dparts[2] = t[2];
            break;

        case '3': // yyyy-mm-dd
            var t = $( "#" + id ).val().split( '-' );
            dparts[0] = t[2];
            dparts[1] = t[1];
            dparts[2] = t[0];
            break;

        case '4': // yyyy/mm/dd
            var t = $( "#" + id ).val().split( '/' );
            dparts[0] = t[2];
            dparts[1] = t[1];
            dparts[2] = t[0];
            break;

        case '5': // yyyymmdd
            dparts[0] = $( "#" + id ).val().substr( 6, 2 );
            dparts[1] = $( "#" + id ).val().substr( 4, 2 );
            dparts[2] = $( "#" + id ).val().substr( 0, 4 );
            break;

        case '1': // dd/mm/yyyy
        default:
            var t = $( "#" + id ).val().split( '/' );
            dparts[0] = t[0];
            dparts[1] = t[1];
            dparts[2] = t[2];
            break;
    }

    return dparts;
}

