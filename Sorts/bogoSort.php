<?php
function consoleLog()
{
    $args = func_get_args();
    if(!$args)
    {
        return;
    }
    $output = $args[0];
    if(count($args)>1)
    {
        $output = call_user_func_array('sprintf', $args);
    }
    else
    {
        if(!is_scalar($output))
        {
            $output = var_export($output, true);
        }
    }

    echo "$output \n";
}

function array_sorted($arr)
{
    $length = count($arr);
    if ($length < 2)
    {
        return true;
    }
    for ($i = 0;$i < $length - 1;$i++)
    {
        if ($arr[$i] > $arr[$i + 1])
        {
            return false;
        }
    }
    return true;
}

function array_shuffle(&$arr)
{
    for ($i = count($arr) - 1;$i; $i--)
    {
        $m = mt_rand(0, $i);
        $n = $arr[$i - 1];
        $arr[$i - 1] = $arr[$m];
        $arr[$m] = $n;
    }
}

function bogoSort($items)
{
    while (!array_sorted($items))
    {
        array_shuffle($items);
    }

    return $items;
}
$ar = array(5, 6, 7, 8, 1, 2, 12, 14);
consoleLog($ar);
$ar = bogoSort($ar);
consoleLog($ar);

