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

function KadaneAlgo($array)
{
    $cummulativeSum = 0;
    $maxSum = 0;
    for ($i = 0;
         $i < count($array); $i++) {
        $cummulativeSum = $cummulativeSum + $array[$i];
        if ($cummulativeSum < 0) {
            $cummulativeSum = 0;
        }
        if ($maxSum < $cummulativeSum) {
            $maxSum = $cummulativeSum;
        }
    }
    return $maxSum;
}

function main()
{
    $myArray = array(1, 2, 3, 4, -6);
    $result = KadaneAlgo($myArray);
    consoleLog($result);
}

main();

