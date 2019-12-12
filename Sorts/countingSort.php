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

function countingSort($arr, $min, $max)
{
    $i = null;
    $z = 0;
    $count = array();
    for ($i = $min; $i <= $max; $i++) {
        $count[$i] = 0;
    }
    for ($i = 0; $i < count($arr); $i++) {
        $count[$arr[$i]]++;
    }
    for ($i = $min; $i <= $max; $i++) {
        while ($count[$i]-- > 0) {
            $arr[$z++] = $i;
        }
    }
    return $arr;
}

$arr = array(3, 0, 2, 5, 4, 1);
consoleLog("-----before sorting-----");
consoleLog($arr);
consoleLog("-----after sorting-----");
consoleLog(countingSort($arr, 0, 5));

