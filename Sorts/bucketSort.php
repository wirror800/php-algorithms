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

function bucketSort($list, $size=5)
{
    if (count($list) === 0)
    {
        return $list;
    }
    $min = $list[0];
    $max = $list[0];
    for ($iList = 0;
         $iList < count($list); $iList++) {
        if ($list[$iList] < $min) {
            $min = $list[$iList];
        } else if ($list[$iList] > $max) {
            $max = $list[$iList];
        }
    }
    $count = floor($max - $min / $size) + 1;
    $buckets = array();
    for ($iCount = 0;
         $iCount < $count; $iCount++) {
        array_push($buckets, array());
    }
    for ($iBucket = 0;
         $iBucket < count($list); $iBucket++) {
        $key = floor($list[$iBucket] - $min / $size);
        array_push($buckets[$key], $list[$iBucket]);
    }
    $sorted = array();
    for ($iBucket = 0;
         $iBucket < count($buckets); $iBucket++) {
        sort($buckets[$iBucket]);
        $arr = $buckets[$iBucket];
        for ($iSorted = 0;
             $iSorted < count($arr); $iSorted++) {
            array_push($sorted, $arr[$iSorted]);
        }
    }
    return $sorted;
}

$arrOrignal = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($arrOrignal);
$arrSorted = bucketSort($arrOrignal);
consoleLog($arrSorted);

