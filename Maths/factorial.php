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

"use strict";
function calc_range($num)
{
    $i = 1;
    $range = array();
    while ($i <= $num) {
        array_push($range, $i);
        $i += 1;
    }
    return $range;
}

function calc_factorial($num)
{
    $factorial = null;
    $range = calc_range($num);
    if ($num < 0) {
        new \Exception("Sorry, factorial does not exist for negative numbers.") ;
    }
    if ($num === null) {
        new \Exception("Sorry, factorial does not exist for null or undefined numbers.")  ;
    }
    if ($num === 0) {
        return "The factorial of 0 is 1.";
    }
    if ($num > 0) {
        $factorial = 1;
        foreach($range as $i) {
            $factorial = $factorial * $i;
        }
        return "The factorial of " . $num . " is " . $factorial;
    }
}

consoleLog(calc_factorial(10));

