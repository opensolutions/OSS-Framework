//****************************************************************************
// Toggle functions
//****************************************************************************

/**
 * This function is handling toggle elements.
 *
 * First function unbinds toggle element, removes label type and pointer.
 * Then creates throbber and add it to div trobber with id throb-{toggle element id}.
 * div for throbber should be created manualy. Function only assings throbber to it. After
 * that it calls AJAX for passed URL and data. If responce ok flag ok is set to true otherwise
 * error message is show. If we have AJAX error ten ossAjaxErrorHandler calls. After AJAX error
 * or success handlers function sets back label type and pointer by flags On and Ok , kills throbber
 * end bind same function again for toggle element.
 *
 * @param e Element witch will be edited
 * @param Url This is URL for AJAX.
 * @param data Data for AJAX to post.
 * @param delElement Element witch will be removed
 */
function ossToggle( e, Url, data, delElement )
{
    e.unbind();
    if( e.hasClass( 'disabled' ) )
        return;

    var on = true;
    if( e.hasClass( 'btn-danger' ) ) {
        e.removeClass( "btn-danger" ).attr( 'disabled', 'disabled' );
    } else {
        on = false;
        e.removeClass( "btn-success" ).attr( 'disabled', 'disabled' );
    }

    var Throb = ossThrobber( 18, 10, 1, 'images/throbber_16px.gif' ).appendTo( $( '#throb-' + e.attr( 'id' ) ).get(0) ).start();

    var ok = false;

    $.ajax({
        url: Url,
        data: data,
        async: true,
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
        error: ossAjaxErrorHandler,
        complete: function(){

            if( !ok ) on = !on;

            if( on ) {
                e.html( "Yes" ).addClass( "btn-success" ).removeAttr( 'disabled' );
            } else {
                e.html( "No" ).addClass( "btn-danger" ).removeAttr( 'disabled' );
            }

            $( '#throb-' + e.attr( 'id' ) ).html( "" );

            e.click( function( event ){
                ossToggle( e, Url, data );
            });

            if( typeof( delElement ) != undefined ) {
            	$( delElement ).hide( 'slow', function(){ $( delElement ).remove() } );;
            }

        }
    });

    return on;
}

