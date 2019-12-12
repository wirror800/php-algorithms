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

$jumpSearch = function ($arr, $value) {
    $length = count($arr);
    $step = floor(sqrt($length));
    $lowerBound = 0;
    while ($arr[min($step, $length) - 1] < $value) {
        $lowerBound = $step;
        $step += $step;
        if ($lowerBound >= $length) {
            consoleLog("not found %s", $value);
            return -1;
        }
    }
    $upperBound = min($step, $length);
    while ($arr[$lowerBound] < $value) {
        $lowerBound++;
        if ($lowerBound === $upperBound) {
            consoleLog("not found %s", $value);
            return -1;
        }
    }
    if ($arr[$lowerBound] === $value) {
        consoleLog("found %s", $value);
        return $lowerBound;
    }
    return -1;
};
$arr = array(0, 0, 4, 7, 10, 23, 34, 40, 55, 68, 77, 90);
$jumpSearch($arr, 4);
$jumpSearch($arr, 34);
$jumpSearch($arr, 77);

