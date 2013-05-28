//****************************************************************************
// Alert message functions
//****************************************************************************

$( 'document' ).ready( function(){
    // A good percentage of pages will have message boxes - this activates them all
    $(".alert-message").alert();
    $( ".alert" ).alert();
});

/**
 * This function adding oss messages.
 *
 * Function defines message box. And when check where the message should be shown.
 * First it is looking for modal dialog to display oss message in it.
 * If modal dialog was not found it looks for class breadcrumb, witch is page header,
 * and insert oss message after it. And finaly if no modal dialog or breadcrumb was found
 * it insert oss message at the top of main div.
 *
 * @param msg  This is main text of oss message.
 * @param type This is type of oss message(success, error, info, etc.).
 * @param handled This is means that it came from ossAjaxErrorHandler and message can be dispalyed on modal dialog
 */
function ossAddMessage( msg, type, handled )
{
    rand = Math.floor( Math.random() * 1000000 );

    msgbox = '<div id="oss-message-' + rand + '" class="alert alert-' + type + ' fade in">\
                                <a class="close" href="#" data-dismiss="alert">×</a>\
                                    '+ msg + '</div>';

    if( $('.modal-body:visible').length && handled )
    {
        $('.modal-body').prepend( msgbox );
    }
    else if( $('.page-header').length )
    {
        $('.page-header').after( msgbox );

    }
    else if( $('.page-content').length )
    {
        $('.page-header').after( msgbox );

    }
    else if( $( ".breadcrumb" ).length )
    {
        $('.breadcrumb').after( msgbox );
    }
    else if( $( ".container" ).length )
    {
        $('.container').before( msgbox );
    }
    else if( $('#main').length )
    {
        $('#main').prepend( msgbox );
    }

    $( "#oss-message-" + rand ).alert();
}

/**
 * This function hides displayed oss messages.
 *
 * Useful then you want to close all previous oss messages.
 */
function ossCloseOssMessages()
{
    $( "div[id|='oss-message']" ).hide();
}

