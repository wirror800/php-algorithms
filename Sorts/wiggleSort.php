<?php
function consoleLog()
{
    $args = func_get_args();
    if (!$args) {
        return;
    }
    $output = $args[0];
    if (count($args) > 1) {
        $output = call_user_func_array('sprintf', $args);
    } else {
        if (!is_scalar($output)) {
            $output = var_export($output, true);
        }
    }

    echo "$output \n";
}

/*
 * Wiggle sort sorts the array into a wave like array.
 * An array ‘arr[0..n-1]’ is sorted in wave form if arr[0] >= arr[1] <= arr[2] >= arr[3] <= arr[4] >= …..
 *
 */
function wiggleSort(&$arr)
{
    for ($i = 0; $i < count($arr); ++$i)
    {
        $shouldNotBeLessThan = $i % 2;
        $isLessThan = isset($arr[$i + 1])?$arr[$i] < $arr[$i + 1]:false;
        if ($shouldNotBeLessThan && $isLessThan)
        {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$i + 1];
            $arr[$i + 1] = $tmp;
        }
    }
}

$arr = array(3, 5, 2, 1, 6, 4);
consoleLog($arr);
wiggleSort($arr);
consoleLog($arr);

