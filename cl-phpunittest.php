<?php
$checkfails = $checktests = 0;
$checkfout = NULL;

function check( $what, $result, $expected = NULL )
{
    # Allow $what to be optional
    if( ! isset( $expected ) ) {
        $expected = $result;
        $result = eval( "return " . $what . ";" );
    }

    if( is_bool( $expected ) )
        checkbool( $what, $result, $expected );
    else if( is_num( $expected ) )
        checknum( $what, $result, $expected );
    else
        checkstr( $what, $result, $expected );
}

function checkstr( $what, $result, $expected )
{
    global $checkfails, $checktests;
    $checktests++;

    $result = rtrim( $result );
    $expected = rtrim( $expected );
    if( $result === $expected ) {
        checkprint( "    ok: $what is $expected\n" );
    }
    else {
        checkprint( "Not ok: With:     $what\n" .
               "        Expected: $expected\n" .
               "        Got:      $result\n" .
               "        at:       " . checkcallsite() . "\n" );
        $checkfails++;
    }
}

function checkbool( $what, $result, $expected = NULL )
{
    if( ! function_exists('bool_to_string') )
    {
        function bool_to_string( $b ) { return $b ? "True" : "False"; }
    }

    if( ! is_string( $what ) )
        $what = bool_to_string( $what );
    checkstr( $what, bool_to_string( $result ), bool_to_string( $expected ) );
}

function checknum( $what, $result, $expected )
{
    checkstr( strval( $result ), strval( $expected ) );
}

function checkheading( $what )
{
    $what .= " at: " . checkcallsite();
    $underline = str_repeat( "=", strlen( $what ) );
    if( $checktests != 0 )
        checkprint( "\n" );
    checkprint(
        "$what\n" .
        "$underline\n" );
}

function failed( $reason )
{
    global $checkfails, $checktests;
    $checktests++;
    $checkfails++;
    checkprint( "Not ok: $reason\n" );
}

function checkcallsite()
{
    $backtrace = debug_backtrace();
    $index = 0;
    while( $backtrace[$index]["file"] == __FILE__ )
        ++$index;
    return basename( $backtrace[$index]["file"] ) . ": " . $backtrace[$index]["line"];
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

function report()
{
    global $checkfails, $checktests;
    checkprint( "$checkfails fails, $checktests tests\n" );
}
?>
