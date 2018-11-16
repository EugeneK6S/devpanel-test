--TEST--
Test symfony_debug_backtrace in case of non fatal error
--SKIPIF--
<<<<<<< HEAD
<?php if (!extension_loaded("symfony_debug")) print "skip"; ?>
=======
<?php if (!extension_loaded('symfony_debug')) {
    echo 'skip';
} ?>
>>>>>>> git-aline/master/master
--FILE--
<?php

function bar()
{
    bt();
}

function bt()
{
    print_r(symfony_debug_backtrace());
<<<<<<< HEAD

=======
>>>>>>> git-aline/master/master
}

bar();

?>
--EXPECTF--
Array
(
    [0] => Array
        (
            [file] => %s
            [line] => %d
            [function] => bt
            [args] => Array
                (
                )

        )

    [1] => Array
        (
            [file] => %s
            [line] => %d
            [function] => bar
            [args] => Array
                (
                )

        )

)
