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

function euclideanGCDRecursive($first, $second)
{
    if ($second === 0) {
        return $first;
    } else {
        return euclideanGCDRecursive($second, $first % $second);
    }
}

function euclideanGCDIterative($first, $second)
{
    while ($second !== 0) {
        $temp = $second;
        $second = $first % $second;
        $first = $temp;
    }
    return $first;
}

function main()
{
    $first = 20;
    $second = 30;
    consoleLog("Recursive GCD for %d and %d is %d", $first, $second, euclideanGCDRecursive($first, $second));
    consoleLog("Iterative GCD for %d and %d is %d", $first, $second, euclideanGCDIterative($first, $second));
}

main();

