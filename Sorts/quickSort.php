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

function quickSort($items)
{
    $length = count($items);
    if ($length <= 1) {
        return $items;
    }
    $PIVOT = $items[0];
    $GREATER = array();
    $LESSER = array();
    for ($i = 1;
         $i < $length; $i++) {
        if ($items[$i] > $PIVOT) {
            array_push($GREATER, $items[$i]);
        } else {
            array_push($LESSER, $items[$i]);
        }
    }
    $sorted = quickSort($LESSER);
    array_push($sorted, $PIVOT);
    $sorted = array_merge($sorted,quickSort($GREATER));
    return $sorted;
}

$ar = array(0, 5, 3, 2, 2);
consoleLog($ar);
$ar = quickSort($ar);
consoleLog($ar);

