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
        elseif(is_bool($output))
        {
            $output = $output ? 'true' : 'false';
        }
    }

    echo "$output \n";
}

function intToHex($num)
{
    switch ($num) {
        case 10:
            return "A";

        case 11:
            return "B";

        case 12:
            return "C";

        case 13:
            return "D";

        case 14:
            return "E";

        case 15:
            return "F";

    }
    return $num;
}

function decimalToHex($num)
{
    $hex_out = array();
    while ($num > 15) {
        array_push($hex_out, intToHex($num % 16));
        $num = floor($num / 16);
    }
    return intToHex($num) . join("", $hex_out);
}

consoleLog(decimalToHex(999098) === "F3EBA");
consoleLog(decimalToHex(123) === "7B");

