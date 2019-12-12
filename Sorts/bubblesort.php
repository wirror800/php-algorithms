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

function bubbleSort(&$items)
{
    $length = count($items);
    for ($i = $length - 1;
         $i > 0; $i--) {
        for ($j = $length - $i;
             $j > 0; $j--) {
            if ($items[$j] < $items[$j - 1]) {
                $tmp = $items[$j];
                $items[$j] = $items[$j - 1];
                $items[$j - 1] = $tmp;
            }
        }
    }
}

$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog("-----before sorting-----");
consoleLog($ar);
bubbleSort($ar);
consoleLog("-----after sorting-----");
consoleLog($ar);


function bubbleSort2($arr)
{
    $swapped = true;
    while ($swapped) {
        $swapped = false;
        for ($i = 0;
             $i < count($arr) - 1; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$i + 1];
                $arr[$i + 1] = $temp;
                $swapped = true;
            }
        }
    }
    return $arr;
}

consoleLog("-----before sorting-----");
$array = array(10, 5, 3, 8, 2, 6, 4, 7, 9, 1);
consoleLog($array);
consoleLog("-----after sorting-----");
consoleLog(bubbleSort2($array));

