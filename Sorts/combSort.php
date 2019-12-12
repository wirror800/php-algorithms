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

function combSort($list)
{
    if (count($list) === 0) {
        return $list;
    }
    $shrink = 1.3;
    $gap = count($list);
    $isSwapped = true;
    $i = 0;
    while ($gap > 1 || $isSwapped) {
        $gap = intval(floatval($gap) / $shrink, 10);
        $isSwapped = false;
        $i = 0;
        while ($gap + $i < count($list)) {
            if ($list[$i] > $list[$i + $gap]) {
                $value = $list[$i];
                $list[$i] = $list[$i + $gap];
                $list[$i + $gap] = $value;
                $isSwapped = true;
            }
            $i += 1;
        }
    }
    return $list;
}

$arrOrignal = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($arrOrignal);
$arrSorted = combSort($arrOrignal);
consoleLog($arrSorted);

