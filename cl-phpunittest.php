<?php
$checkfails = $checktests = 0;
$checkfout = NULL;

function checkglobber()
{
    $calling_file = checkcallfile();
    foreach( glob( 'test-*.php' ) as $test_file ) {
        if( $test_file != $calling_file )
            include_once( $test_file );
    }
}

function  checkheading( $heading )
{
    global $checktests;

    $heading .= " at: " . checkcallsite();
    $underline = str_repeat( "=", strlen( $heading ) );
    if( $checktests != 0 )
        checkprint( "\n" );
    checkprint(
        "$heading\n" .
        "$underline\n" );
}

function check( $what, $result, $expected = NULL )
{
    # Allow $what to be optional
    if( ! isset( $expected ) ) {
        $expected = $result;
        $result = eval( "return " . checkdisplayable( $what ) . ";" );
    }

    checkcompare( $what, $result, $expected );
}

function checkstr( $what, $result, $expected = NULL )
{
    # Allow $what to be optional
    if( ! isset( $expected ) ) {
        $expected = $result;
        $result = $what;
    }

    checkcompare( $what, $result, $expected );
}

function checkrtrim( $what, $result, $expected = NULL )
{
    check( rtrim( $what ), rtrim( $result ), isset( $expected ) ? rtrim( $expected ) : NULL );
}

function checkstrrtrim( $what, $result, $expected = NULL )
{
    checkstr( rtrim( $what ), rtrim( $result ), isset( $expected ) ? rtrim( $expected ) : NULL );
}

function failed( $reason )
{
    global $checkfails, $checktests;
    $checktests++;
    $checkfails++;
    checkprint( "Not ok: \"$reason\" at " . checkcallsite() . "\n" );
}

function checkcompare( $what, $result, $expected )
{
    global $checkfails, $checktests;
    $checktests++;

    if( $result === $expected ) {
        checkprint( "    ok: " . checkdisplayable( $what ) . " is " . checkdisplayable( $expected ) . "\n" );
    }
    else {
        checkprint( "Not ok: With:     $what\n" .
                    "        Expected: " . checkdisplayable( $expected ) . "\n" .
                    "        Got:      " . checkdisplayable( $result ) . "\n" .
                    "        at:       " . checkcallsite() . "\n" );
        $checkfails++;
    }
}

function checkdisplayable( $v )
{
    if( is_bool( $v ) )
        return $v ? "True" : "False";
    return strval( $v );
}

function checkcallsite( $want_line_num = True )
{
    $backtrace = debug_backtrace();
    $index = 0;
    while( $backtrace[$index]["file"] == __FILE__ )
        ++$index;
    if( $want_line_num )
        return basename( $backtrace[$index]["file"] ) . ": " . $backtrace[$index]["line"];
    return basename( $backtrace[$index]["file"] );
}

function checkcallfile()
{
    return checkcallsite( False );
}

function checkprint( $message )
{
    global $checkfout;

    if( ! isset( $checkfout ) )
        $checkfout = fopen( "check-out.txt", "wt" );
    if( $checkfout !== FALSE )
        fwrite( $checkfout, $message );
    print( $message );
}

function checkoutputclose()
{
    if( isset( $checkfout ) && $checkfout !== FALSE ) {
        fclose( $checkfout );
        $checkfout = FALSE;
    }
}

function report()
{
    global $checkfails, $checktests;
    checkprint( "$checkfails fails, $checktests tests\n" );
}
?>
