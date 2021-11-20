<?php
include( '../cl-phpunittest.php' );

checkheading( "This section should all PASS (OK)" );

check( 1, 1 );
check( 1 + 1, 2 );
check( "Number test", 1, 1 );
checkeval( "1", 1 );
checkeval( "1 + 1", 2 );

checkeval( "Test", "Test" );
check( "String test", "Test", "Test" );

checkeval( "strlen( 'Test' )", 4 );
check( "strlen() should indicate 'Test' is 4 characters long", strlen( 'Test' ), 4 );

checkeval( "1 == 1", True );
checkeval( "1 != 1", False );
check( True, True );
checkeval( "True", True );

checkstr( "Test", "Test" );
checkstr( "String test", "Test", "Test" );

checkrtrim( "Test\n", "Test" );
checkstrrtrim( "Test\n", "Test" );


checkheading( "This section should all FAIL (NOT OK)" );

check( "Test", 2 ); # Type mismatch

check( 1, 2 );
check( 1 + 1, 3 );
checkeval( "1 + 1", 3 );

checkeval( "Test", "Test2" );
check( "String test", "Test", "Test2" );

checkeval( "strlen( 'Test' )", 5 );

checkeval( "1 == 1", False );
checkeval( "1 != 1", True );
check( True, False );
checkeval( "True", False );

checkstr( "Test", "Test2" );
checkstr( "String test", "Test", "Test2" );

checkrtrim( "Test\n", "Test2" );
checkstrrtrim( "Test\n", "Test2" );

checkfailed( "Too much effort" );

checkglobber();

checktodo( "Bring peace to the world" );

$is_feature_test_run = False;
checkfeature( "checkfeature() Tests", function()
{
    global $is_feature_test_run;
    $is_feature_test_run = True;
});
check( "\$is_feature_test_run should be True after checkfeature() test", $is_feature_test_run, True );

checkheading( "checkwrap() tests" );
$old_wrap = checkwrap( 40 );
check( "Old wrap setting should be 0", $old_wrap, 0 );
check( "A random sounding test description with a_very_long_word_in_it_to_make_life_difficult() to exercise checkwrap() functionality", True, True );
check( "Querying checkwrap() without a parameter should return the current wrap length of 40", checkwrap(), 40 );
$second_old_wrap = checkwrap( $old_wrap );
check( "Second old wrap setting should be 40", $second_old_wrap, 40 );

checkfeature( "checkwrap() in checkfeature() Tests", function()
{
    $old_wrap = checkwrap( 40 );
    check( "After setting checkwarp( 40 ) in checkfeature() returned old wrap setting should be 0", $old_wrap, 0 );
    $old_wrap = checkwrap();
    check( "After querying checkwarp() in checkfeature() returned old wrap setting should be 0", $old_wrap, 40 );
});
$old_wrap = checkwrap();
check( "Wrap setting after leaving checkwrap() in checkfeature() tests should be reverted to 0", $old_wrap, 0 );

checkreport();

checkoutputclose();

# Very clumsy way of testing this output's run with the reference output
if( str_replace( "\r\n", "\n", file_get_contents("check-out.txt")) === str_replace( "\r\n", "\n", file_get_contents("check-out-reference.txt")) )
    echo "\nOK: TEST PASSED - Comparison against reference is OK\n";
else
    echo "\nFAIL: TEST FAILED - Comparison against reference has FAILED\n";
?>
