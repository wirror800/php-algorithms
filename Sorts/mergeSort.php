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

function merge($list1, $list2)
{
    $results = array();
    while (count($list1) && count($list2)) {
        if ($list1[0] <= $list2[0]) {
            array_push($results, array_shift($list1));
        } else {
            array_push($results, array_shift($list2));
        }
    }
    return array_merge($results, $list1, $list2);
}

function mergeSort($list)
{
    if (count($list) < 2) {
        return $list;
    }
    $listHalf = floor(count($list) / 2);
    $subList1 = array_slice($list,0, $listHalf);
    $subList2 = array_slice($list, $listHalf, count($list));
    return merge(mergeSort($subList1), mergeSort($subList2));
}

$unsortedArray = array(10, 5, 3, 8, 2, 6, 4, 7, 9, 1);
consoleLog("-----before sorting-----");
consoleLog($unsortedArray);
$sortedArray = mergeSort($unsortedArray);
consoleLog("-----after sorting-----");
consoleLog($sortedArray);

