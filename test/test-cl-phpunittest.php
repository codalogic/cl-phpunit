<?php
include( '../cl-phpunittest.php' );

checkheading( "Start of testing" );

check( 1, 1 );
check( 1 + 1, 2 );
check( "Number test", 1, 1 );
check( "1", 1 );
check( "1 + 1", 2 );

check( "Test", "Test" );
#check( "Test2", "Test" );
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

failed( "Too much effort" );

report();
?>
