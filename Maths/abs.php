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

function abs_val($num)
{
    "use strict";
    if ($num < 0) {
        return -$num;
    }
    return $num;
}

consoleLog("The absolute value of -34 is " . abs_val(-34));
consoleLog("The absolute value of 34 is " . abs_val(34));

