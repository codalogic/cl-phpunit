<?php
$checkfails = $checktests = 0;
$checkfout = NULL;
$checktodos = [];

function checkglobber()
{
    $calling_file = checkcallfile();
    foreach( glob( 'test-*.php' ) as $test_file ) {
        if( $test_file != $calling_file )
            include_once( $test_file );
    }
}

function checkfeature( $heading, $func )
{
    checkheading( $heading );
    $func();
}

function  checkheading( $heading )
{
    global $checktests;

    $heading .= " at: " . checkcallsite();
    $underline = str_repeat( "=", strlen( $heading ) );
    if( $checktests != 0 )
        checkprint( "\n" );
    checkprint(
        "       $heading\n" .
        "       $underline\n" );
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

function checkfailed( $reason )
{
    global $checkfails, $checktests;
    $checktests++;
    $checkfails++;
    checkprint( "Not ok: \"$reason\" at " . checkcallsite() . "\n" );
}

function checktodo( $task )
{
    global $checktodos;

    $task = "\"$task\" at " . checkcallsite();
    checkprint( "  TODO: $task\n" );
    $checktodos[] = $task;
}

function checkcompare( $what, $result, $expected )
{
    global $checkfails, $checktests;
    $checktests++;

    if( $result === $expected ) {
        checkprint( "    ok: " . checkdisplayable( $what ) . " --> " . checkdisplayable( $expected ) . "\n" );
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
        return basename( $backtrace[$index]["file"] ) . "(" . $backtrace[$index]["line"] . ")";
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

function checkreport()
{
    global $checkfails, $checktests, $checktodos;

    $num_todos = count( $checktodos );
    if( $num_todos > 0 ) {
        checkprint( "\n    TODOs:\n");
        foreach( $checktodos as $task )
            checkprint( "    - $task\n" );
    }

    checkprint( "\n$checkfails fails, $num_todos todos, $checktests tests\n" );
}

class CheckStopwatch {
    private $start_time = 0;
    private $stop_time = 0;

    function __construct() {
        $this->Start();
    }

    public function Start() {
        $this->stop_time = 0;
        $this->start_time = microtime(True);
    }

    public function Stop() {
        $this->stop_time = microtime(True);
    }

    public function ElapsedMilliSeconds() {
        $end_time = $this->stop_time;
        if( $end_time == 0 )
            $end_time = microtime(True);
        return (int)(($end_time - $this->start_time) * 1000.0);
    }
}
?>
