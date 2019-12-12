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

function insertionSort(&$unsortedList)
{
    $len = count($unsortedList);
    for ($i = 1;
         $i < $len; $i++) {
        $tmp = $unsortedList[$i];
        for ($j = $i - 1;
             $j >= 0 && $unsortedList[$j] > $tmp; $j--) {
            $unsortedList[$j + 1] = $unsortedList[$j];
        }
        $unsortedList[$j + 1] = $tmp;
    }
}

$arr = array(5, 3, 1, 2, 4, 8, 3, 8);
insertionSort($arr);
consoleLog($arr);

