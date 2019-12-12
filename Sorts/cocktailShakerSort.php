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

function cocktailShakerSort(&$items)
{
    for ($i = count($items) - 1;
         $i > 0; $i--) {
        $swapped = false;
        $temp = null;
        $j = null;
        for ($j = count($items) - 1; $j > $i; $j--) {
            if ($items[$j] < $items[$j - 1]) {
                $temp = $items[$j];
                $items[$j] = $items[$j - 1];
                $items[$j - 1] = $temp;
                $swapped = true;
            }
        }
        for ($j = 0; $j < $i; $j++) {
            if ($items[$j] > $items[$j + 1]) {
                $temp = $items[$j];
                $items[$j] = $items[$j + 1];
                $items[$j + 1] = $temp;
                $swapped = true;
            }
        }
        if (!$swapped) {
            return;
        }
    }
}

$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
cocktailShakerSort($ar);
consoleLog($ar);

