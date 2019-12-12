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

"use strict";
function find_lcm($num_1, $num_2)
{
    $max_num = null;
    $lcm = null;
    if ($num_1 > $num_2) {
        $max_num = $num_1;
    } else {
        $max_num = $num_2;
    }
    $lcm = $max_num;
    while (true) {
        if ($lcm % $num_1 === 0 && $lcm % $num_2 === 0) {
            break;
        }
        $lcm += $max_num;
    }
    return $lcm;
}

$num_1 = 12;
$num_2 = 76;
consoleLog(find_lcm($num_1, $num_2));

