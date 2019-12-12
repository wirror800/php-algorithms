<?php
function consoleLog()
{
    $args = func_get_args();
    if(!$args)
    {
        return;
    }
    $output = $args[0];
    if(count($args)>1)
    {
        $output = call_user_func_array('sprintf', $args);
    }
    else
    {
        if(!is_scalar($output))
        {
            $output = var_export($output, true);
        }
    }

    echo "$output \n";
}

function fib($n)
{
    $table = array();
    array_push($table, 1);
    array_push($table, 1);
    for ($i = 2;$i < $n; ++$i)
    {
        array_push($table, $table[$i - 1] + $table[$i - 2]);
    }

    consoleLog("Fibonacci #%d = %s", $n, $table[$n - 1]);
}

fib(1);
fib(2);
fib(200);
fib(5);
fib(10);

