//****************************************************************************
// Validator Functions
//****************************************************************************

/**
 * This function is for validating input field.
 *
 * Function cheks if the input field has tha value if not set error,
 * and sets valid to false. If value not empty and email flag sets to
 * true then function calls validate email, and if email validate function
 * removes class error, if email not valid function add set error and sets
 * valid to false. and if email flag is false, and value is not empty, we remove
 * error from input field.
 *
 * @param string fieldName The field id, we nead only id because we have to build other id from it.
 * @param bool email The email flag, witch means that imput field is email and we nead to validate it as email.
 */
function ossJscriptFieldValidator( fieldName, email )
{
    if( $( '#' + fieldName ).val() == "" )
    {
        $( '#div-form-' + fieldName ).addClass( 'error' );
        $( '#help-' + fieldName ).html( "Value is required and can't be empty." );
        $( '#help-' + fieldName ).show( );
    }
    else
    {
        if( email )
        {
            if( ossValidateEmail( $( '#' + fieldName ).val() ) )
            {
                $( '#div-form-' + fieldName ).removeClass( 'error' );
                $( '#help-' + fieldName ).hide( );
            }
            else
            {
                $( '#div-form-' + fieldName ).addClass( 'error' );
                $( '#help-' + fieldName ).html( "<br/>This is not a valid email address." );
                $( '#help-' + fieldName ).show( );
            }
        }
        else
        {
            $( '#div-form-' + fieldName ).removeClass( 'error' );
            $( '#help-' + fieldName ).hide( );
        }
    }
}


/**
 * This function is simply checks regular expresion of given string, and return if it is email addres, otherwise return false.
 *
 * @param string email The string witch is validating as email address.
 * @return bool
 */
function ossValidateEmail( email)
{
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( emailReg.test( email ) )
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * Check if date matches date regular expresion
 *
 * @param id The date field id
 * @return bool
 */
function ossValidateDateField( id )
{
    // get the appropriate regexp

    var re_day_strict   = "((0[1-9]{1})|([12][0-9]{1})|(3[01]{1}))";
    var re_month_strict = "((0[1-9]{1})|(1[012]{1}))";

    var re_day   = "((0[1-9]{1})|([12][0-9]{1})|(3[01]{1})|[1-9]{1})";
    var re_month = "((0[1-9]{1})|(1[012]{1})|[1-9]{1})";
    var re_year  = "(\\d{4})";
    var re;
    var df;

    // case values correspond to OSS_Date DF_* constants
    switch( $( "#" + id ).attr( 'data-dateformat' ) )
    {
        case '2':
            re = re_month + '\\/' + re_day + '\\/' + re_year;
            df = 'MM/DD/YYYY';
            break;

        case '3':
            re = re_year + '-' + re_month + '-' + re_day;
            df = 'YYYY-MM-DD';
            break;

        case '4':
            re = re_year + '\\/' + re_month + '\\/' + re_day;
            df = 'YYYY/MM/DD';
            break;

        case '5':
            re = re_year + re_month_strict + re_day_strict;
            df = 'YYYYMMDD';
            break;

        case '1':
        default:
            re = re_day + '\\/' + re_month + '\\/' + re_year;
            df = 'DD/MM/YYYY';
            break;
    }

    re = '^' + re + '$';
    re = new RegExp( re );

    if( $( "#" + id ).val().match( re ) )
    {
        $( "#div-form-" + id ).removeClass( "error" );

        $( '#help-' + id ).html( "" );
        $( '#help-' + id ).hide( );
        return true;
    }
    else
    {
        $( "#div-form-" + id ).addClass( "error" );
        if( $( "#help-" + id ).length == 0 )
            $( "#div-controls-" + id ).append( '<p id="help-' + id + '" class="help-block"></p>' );
        $( '#help-' + id ).html( "Bad date - use " + df );
        $( '#help-' + id ).show( );
        return false;
    }
}

