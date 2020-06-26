# cl-phpunittest
A REALLY simple file for testing PHP.

## Usage
Download `cl-phpunittest.php` to a test directory.

In the test directory write code like this:

```php
<?php
include( 'cl-phpunittest.php' );
include( '../my-file-to-test.php' );

check( <what I'm testing>, '<string representing what I hope to get>' );
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
