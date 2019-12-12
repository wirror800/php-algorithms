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

function shellSort($items)
{
    $interval = 1;
    while ($interval < count($items) / 3) {
        $interval = $interval * 3 + 1;
    }
    while ($interval > 0) {
        for ($outer = $interval;
             $outer < count($items); $outer++) {
            $value = $items[$outer];
            $inner = $outer;
            while ($inner > $interval - 1 && $items[$inner - $interval] >= $value) {
                $items[$inner] = $items[$inner - $interval];
                $inner = $inner - $interval;
            }
            $items[$inner] = $value;
        }
        $interval = $interval - 1 / 3;
    }
    return $items;
}

$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
$ar = shellSort($ar);
consoleLog($ar);

