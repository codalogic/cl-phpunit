# cl-phpunittest
A REALLY simple file for testing PHP.

## Usage
Download `cl-phpunittest.php` to a test directory.

In the test directory write code like this:

```php
<?php
include( 'cl-phpunittest.php' );
include( '../my-file-to-test.php' );

check( "<string with what I'm testing>", <value of what I hope to get> );
...

report();
?>
```

If you are testing multiple file, try something like:

```php
<?php
include( 'cl-phpunittest.php' );

include( 'test-my-first-file.php' );
include( 'test-my-second-file.php' );
...

report();
?>
```

It ain't pretty!!!

## check( $statement, $expected )

The `$statement` parameter is a string containing a PHP statement to be
exceuted.

The `$expected` parameter is the expected result.  It can be any PHP type.

## checkstr( $result, $expected )

If you want to compare string values without executing what is in the string
use `checkstr()`.

The `$result` parameter is a string to be compared against the `$expected`
parameter.  Both are strings.

## checkrtrim( $statement, $expected )

Like `check()` but right trims the string returned by evaluating `$statement`
before testing.

## checkstrtrim( $result, $expected )

Like `checkstr()` but right trims the input strings before testing.

## Testing

cd to the `test` directory then run `php test-cl-phpunittest.php`.  The test
run will show failing tests.  This is intentional to detect failing test
scenarios.  The primary test is comparing the generated test output with
the reference test output.
