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

function mean($nums)
{
    "use strict";
    $sum = 0;
    $avg = null;
    foreach($nums as $current) {
        $sum += $current;
    }
    $avg = $sum / count($nums);
    return $avg;
}

consoleLog(mean(array(2, 4, 6, 8, 20, 50, 70)));

