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

function decimalToOctal($num)
{
    $oct = 0;
    $c = 0;
    while ($num > 0) {
        $r = $num % 8;
        $oct = $oct + $r * pow(10, $c++);
        $num = floor($num / 8);
    }
    consoleLog("The decimal in octal is " . $oct);
}

decimalToOctal(2);
decimalToOctal(8);
decimalToOctal(65);
decimalToOctal(216);
decimalToOctal(512);

