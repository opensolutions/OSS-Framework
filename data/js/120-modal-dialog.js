//****************************************************************************
// Modal dialog functions Functions
//****************************************************************************


$( 'document' ).ready( function(){
    // Activate the modal dialog pop up
    $( "a[id|='modal-dialog']" ).bind( 'click', ossOpenModalDialog );
});

/**
 * This function is opening modal dialog with contact us form.
 *
 * First it creats the throbber witch is shown while form is loading by ajax.
 * When fuction creats and opens modal dialog witch is showing throbber.
 * When form is load the throbber is replaced by it. If ajax gets en error the
 * ossAjaxErrorHandler is called.
 *
 * @param event event Its jQuery event, needed to prevent element from default actions.
 */
function ossOpenModalDialog(event) {

    event.preventDefault();

    ossCloseOssMessages();
    if( $( event.target ).is( "i" ) )
        element = $( event.target ).parent();
    else
        element = $( event.target );


    id = element.attr( 'id' ).substr( element.attr( 'id' ).lastIndexOf( '-' ) + 1 );

    if( id.substring( 0, 4 ) == "wide" )
        $( '#modal_dialog' ).addClass( 'modal-wide' );
    else
        $( '#modal_dialog' ).removeClass( 'modal-wide' );

    _createDialog( element.attr( 'href' ) );
};



/**
 * This function creates dialog from given link
 *
 * @param strin url Link to load dialog.
 */
function _createDialog( url )
{
    $('#modal_dialog').html( '<div id="throb" style="padding-left:230px; padding-top:175px; height:275px;"></div>' );

    var Throb = ossThrobber( 100, 20, 1.8 ).appendTo( $( '#throb' ).get(0) ).start();

    dialog = $( '#modal_dialog' ).modal( {
                backdrop: true,
                keyboard: true,
                show: true
    });

    dialog.off( 'hidden' );

    $.ajax({
        url: url,
        async: true,
        cache: false,
        type: 'POST',
        timeout: 10000,
        success:    function(data) {
                        $('#modal_dialog').html( data );
                        $( '#modal_dialog_cancel' ).bind( 'click', function(){
                            dialog.modal('hide');
                            dialog.on( 'hidden', function(){
                                $( '.modal-backdrop' ).remove();
                            });
                        });
                     },

        error:     ossAjaxErrorHandler,
        complete: function(){
            dialog.on( "shown", function(){
                $( '.modal-body' ).scrollTop( 0 );
            });
        }
    });
}

