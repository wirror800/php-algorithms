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

function SearchArray($searchNum, $ar)
{
    $position = Search($ar, $searchNum);
    if ($position != -1) {
        consoleLog("The element was found at " . ($position + 1));
    } else {
        consoleLog("The element not found");
    }
}

function Search($theArray, $key)
{
    for ($n = 0;
         $n < count($theArray); $n++) {
        if ($theArray[$n] == $key) {
            return $n;
        }
    }
    return -1;
}

$ar = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
SearchArray(3, $ar);
SearchArray(4, $ar);
SearchArray(11, $ar);

