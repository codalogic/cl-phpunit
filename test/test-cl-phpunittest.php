<?php
include( '../cl-phpunittest.php' );

checkheading( "This section should all PASS (OK)" );

check( 1, 1 );
check( 1 + 1, 2 );
check( "Number test", 1, 1 );
check( "1", 1 );
check( "1 + 1", 2 );

check( "Test", "Test" );
check( "String test", "Test", "Test" );

check( "strlen( 'Test' )", 4 );

check( "1 == 1", True );
check( "1 != 1", False );
check( True, True );
check( "True", True );

checkstr( "Test", "Test" );
checkstr( "String test", "Test", "Test" );

checkrtrim( "Test\n", "Test" );
checkstrrtrim( "Test\n", "Test" );


checkheading( "This section should all FAIL (NOT OK)" );

check( "Test", 2 ); # Type mismatch

check( 1, 2 );
check( 1 + 1, 3 );
check( "1 + 1", 3 );

check( "Test", "Test2" );
check( "String test", "Test", "Test2" );

check( "strlen( 'Test' )", 5 );

check( "1 == 1", False );
check( "1 != 1", True );
check( True, False );
check( "True", False );

checkstr( "Test", "Test2" );
checkstr( "String test", "Test", "Test2" );

checkrtrim( "Test\n", "Test2" );
checkstrrtrim( "Test\n", "Test2" );

failed( "Too much effort" );

checkglobber();

report();

checkoutputclose();

# Very clumsy way of testing this output's run with the reference output
if( str_replace( "\r\n", "\n", file_get_contents("check-out.txt")) === str_replace( "\r\n", "\n", file_get_contents("check-out-reference.txt")) )
    echo "\nOK: TEST PASSED - Comparison against reference is OK\n";
else
    echo "\nFAIL: TEST FAILED - Comparison against reference is FAILED\n";
?>
