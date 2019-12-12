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

function binarySearch($arr, $i)
{
    $mid = floor(count($arr) / 2);
    if ($arr[$mid] === $i) {
        consoleLog("match %s %s", $arr[$mid], $i);
        return $arr[$mid];
    } else if ($arr[$mid] < $i && count($arr) > 1) {
        binarySearch(array_splice($arr, $mid, -1), $i);
    } else if ($arr[$mid] > $i && count($arr) > 1) {
        binarySearch(array_splice($arr, 0, $mid), $i);
    } else {
        consoleLog("not found %s", $i);
        return -1;
    }
}

$ar = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
binarySearch($ar, 3);
binarySearch($ar, 7);
binarySearch($ar, 13);

