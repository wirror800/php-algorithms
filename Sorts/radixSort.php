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

function radixSort($items, $RADIX=null)
{
    if (is_null($RADIX) || $RADIX < 1) {
        $RADIX = 10;
    }
    $maxLength = false;
    $placement = 1;
    while (!$maxLength) {
        $maxLength = true;
        $buckets = array();
        for ($i = 0;
             $i < $RADIX; $i++) {
            array_push($buckets, array());
        }
        for ($j = 0;
             $j < count($items); $j++) {
            $tmp = $items[$j] / $placement;
            array_push($buckets[floor($tmp % $RADIX)], $items[$j]);
            if ($maxLength && $tmp > 0) {
                $maxLength = false;
            }
        }
        $a = 0;
        for ($b = 0;
             $b < $RADIX; $b++) {
            $buck = $buckets[$b];
            for ($k = 0;
                 $k < count($buck); $k++) {
                $items[$a] = $buck[$k];
                $a++;
            }
        }
        $placement *= $RADIX;
    }
    return $items;
}

$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
$ar = radixSort($ar);
consoleLog($ar);

