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

function cycleSort(&$list)
{
    $writes = 0;
    for ($cycleStart = 0;
         $cycleStart < count($list); $cycleStart++) {
        $value = $list[$cycleStart];
        $position = $cycleStart;
        for ($i = $cycleStart + 1;
             $i < count($list); $i++) {
            if ($list[$i] < $value) {
                $position++;
            }
        }
        if ($position == $cycleStart) {
            continue;
        }
        while ($value == $list[$position]) {
            $position++;
        }
        $oldValue = $list[$position];
        $list[$position] = $value;
        $value = $oldValue;
        $writes++;
        while ($position != $cycleStart) {
            $position = $cycleStart;
            for ($i = $cycleStart + 1;
                 $i < count($list); $i++) {
                if ($list[$i] < $value) {
                    $position++;
                }
            }
            while ($value == $list[$position]) {
                $position++;
            }
            $oldValueCycle = $list[$position];
            $list[$position] = $value;
            $value = $oldValueCycle;
            $writes++;
        }
    }
    return $writes;
}

$arrOrignal = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($arrOrignal);
cycleSort($arrOrignal);
consoleLog($arrOrignal);

