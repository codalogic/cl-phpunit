# cl-phpunittest

A REALLY simple file for unit testing PHP.

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

Alternatively, if you have lots of test files, your main test file can look
like the following and `checkglobber()` will glob() looking for test files
named `test-*.php` in the current directory.

```php
<?php
include( 'cl-phpunittest.php' );

checkglobber();

report();
?>
```

It ain't pretty!!!

## check( $statement, $expected )

The `$statement` parameter is a string containing a PHP statement to be
exceuted.

The `$expected` parameter is the expected result.  It can be any PHP type.

Example:

```php
check( "is_digit( '1' )", True );
```

## check( $description, $result, $expected )

The 3 argument form of `check()` takes a leading test description argument.

The `$description` argument describes the test.

The `$result` parameter is result of the test. It is NOT `eval`ed by the
function.

The `$expected` parameter is the expected result.  It can be any PHP type.

Example:

```php
check( "strlen() should indicate 'Test' is 4 characters long", strlen( 'Test' ), 4 );
```

Note that the test that is run is NOT given to the function as a string.

## checkstr( $result, $expected )

If you want to compare string values without executing what is in the string
use `checkstr()`.

The `$result` parameter is a string to be compared against the `$expected`
parameter.  Both are strings.

Example:

```php
checkstr( $output, "String 1" );
```

## checkrtrim( $statement, $expected )

Like `check()` but right trims the string returned by evaluating `$statement`
before testing.

## checkstrtrim( $result, $expected )

Like `checkstr()` but right trims the input strings before testing.

## checkfailed( $reason )

Record that a test not directly implemented with the `check???()` functions
has failed.

Example:

```php
if( $a != $b || $c != $d )
    checkfailed( 'Complex test condition was not met' );
```

## checktodo( $task )

Record a TODO task in the output.

## Testing

cd to the `test` directory then run `php test-cl-phpunittest.php`.  The test
run will show failing tests.  This is intentional to detect failing test
scenarios.  The primary test is comparing the generated test output with
the reference test output (which is done in the final few lines of the test
file).
