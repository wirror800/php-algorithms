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

function selectionSort(&$items)
{
    $length = count($items);
    for ($i = 0;
         $i < $length - 1; $i++) {
        $min = $i;
        for ($j = $i + 1;
             $j < $length; $j++) {
            if ($items[$j] < $items[$min]) {
                $min = $j;
            }
        }
        if ($min != $i) {
            $tmp = $items[$i];
            $items[$i] = $items[$min];
            $items[$min] = $tmp;
        }
    }
}

$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
selectionSort($ar);
consoleLog($ar);

