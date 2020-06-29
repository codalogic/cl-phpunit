<?php
/*
* Tests for the CheckStopwatch class.  This is in a separate file because it
* involves sleep() commands.  It does NOT adopt the conventional 'test-...'
* naming convention so it is not picked up by checkglobber().
*/

include( '../cl-phpunittest.php' );

checkheading( "CheckStopwatch tests" );

$sw = new CheckStopwatch();
sleep(2);
$ms = $sw->ElapsedMilliSeconds();
check( "After 2 second delay ElapsedMilliseconds() time should be roughly 2 seconds", $ms >= 2000 && $ms <= 2500, True );
sleep(2);
$sw->Stop();
$ms = $sw->ElapsedMilliSeconds();
check( "After 2nd 2 second delay after Stop() ElapsedMilliseconds() time should be roughly 4 seconds", $ms >= 4000 && $ms <= 4500, True );
sleep(2);
$ms = $sw->ElapsedMilliSeconds();
check( "After 3rd 2 second ElapsedMilliseconds() time should still be roughly 4 seconds", $ms >= 4000 && $ms <= 4500, True );

sleep(2);
$sw->Start();
$ms = $sw->ElapsedMilliSeconds();
check( "Immediately after calling Start() ElapsedMilliseconds() time should be roughly 0 seconds", $ms >= 000 && $ms <= 500, True );
sleep(2);
$ms = $sw->ElapsedMilliSeconds();
check( "After 2s delay ElapsedMilliseconds() time should be roughly 2 seconds", $ms >= 2000 && $ms <= 2500, True );
sleep(2);
$sw->Stop();
$ms = $sw->ElapsedMilliSeconds();
check( "After 2nd 2 second delay after Stop() ElapsedMilliseconds() time should be roughly 4 seconds", $ms >= 4000 && $ms <= 4500, True );
sleep(2);
$ms = $sw->ElapsedMilliSeconds();
check( "After 3rd 2 second ElapsedMilliseconds() time should still be roughly 4 seconds", $ms >= 4000 && $ms <= 4500, True );

checkreport();
?>
