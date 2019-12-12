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

function gnomeSort(&$items)
{
    if (count($items) <= 1) {
        return;
    }
    $i = 1;
    while ($i < count($items)) {
        if ($items[$i - 1] <= $items[$i]) {
            $i++;
        } else {
            $temp = $items[$i];
            $items[$i] = $items[$i - 1];
            $items[$i - 1] = $temp;
            $i = max(1, $i - 1);
        }
    }
}

$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
gnomeSort($ar);
consoleLog($ar);

