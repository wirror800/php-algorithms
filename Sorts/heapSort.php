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

function heapify($arr, $index, $heapSize)
{
    $largest = $index;
    $leftIndex = 2 * $index + 1;
    $rightIndex = 2 * $index + 2;
    if ($leftIndex < $heapSize && $arr[$leftIndex] > $arr[$largest]) {
        $largest = $leftIndex;
    }
    if ($rightIndex < $heapSize && $arr[$rightIndex] > $arr[$largest]) {
        $largest = $rightIndex;
    }
    if ($largest !== $index) {
        $temp = $arr[$largest];
        $arr[$largest] = $arr[$index];
        $arr[$index] = $temp;
        $arr=heapify($arr,$largest, $heapSize);
    }

    return $arr;
}

function heapSort($items)
{
    $length = count($items);
    for ($i = floor($length / 2) - 1;
         $i > -1; $i--) {
        $items=heapify($items,$i, $length);
    }
    for ($j = $length - 1;
         $j > 0; $j--) {
        $tmp = $items[0];
        $items[0] = $items[$j];
        $items[$j] = $tmp;
        $items=heapify($items,0, $j);
    }
    return $items;
}
$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
$ar = heapSort($ar);
consoleLog($ar);

