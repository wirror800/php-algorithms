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

function decimalToBinary($num)
{
    $bin = array();
    while ($num > 0) {
        array_unshift($bin, $num % 2);
        $num >>= 1;
    }
    consoleLog("The decimal in binary is " . join("", $bin));
}

decimalToBinary(2);
decimalToBinary(7);
decimalToBinary(35);

