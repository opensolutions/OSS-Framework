//****************************************************************************
// Error Functions
//****************************************************************************

/**
 * This function is handling ajax errors.
 *
 * First function is checking if ajax was called on modal window, if so when
 * it checks if buttons are shown that mean that ajax crashed then modal dialog was
 * submitting and enabling modal dialog buttons. If buttons not visible that means
 * that ajax crashed then the content was loading so it close modal dialog.
 * After that it cheks if throbber (canvas) is showing and if so it closes that too.
 * And after that it calls ossAddMessage.
 *
 */
function ossAjaxErrorHandler( XMLHttpRequest, textStatus, errorThrown )
{
    if( $('#modal_dialog:visible').length )
    {
        if( $('#modal_dialog_save').length ){
            $('#modal_dialog_save').removeAttr( 'disabled' ).removeClass( 'disabled' );
            $('#modal_dialog_cancel').removeAttr( 'disabled' ).removeClass( 'disabled' );
        }
        else
        {
            if( dialog )
            {
                dialog.modal('hide');
            }
        }
    }

    $("#overlay").fadeOut( "slow", function(){ ;
        $("#overlay").remove();
    } );

    if( $('canvas').length ){
        $('canvas').remove();
    }
    ossAddMessage( 'An unexpected error occured.', 'error', true );
}

