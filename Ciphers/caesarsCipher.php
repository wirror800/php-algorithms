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

function stringLength($string)
{
    return strlen(iconv('UTF-8', 'UTF-16LE', $string)) / 2;
}

function charCodeAt($str, $index){
    //not working!

    $char = mb_substr($str, $index, 1, 'UTF-8');
    if (mb_check_encoding($char, 'UTF-8'))
    {
        $ret = mb_convert_encoding($char, 'UTF-32BE', 'UTF-8');
        return hexdec(bin2hex($ret));
    } else {
        return null;
    }
}

function fromCharCode($codes)
{
    if (is_scalar($codes)) $codes= func_get_args();
    $str= '';
    foreach ($codes as $code) $str.= chr($code);
    return $str;
}

function rot13($str)
{
    $response = array();
    $strLength = stringLength($str);
    for ($i = 0;
         $i < $strLength; $i++) {
        $char = charCodeAt($str, $i);
        if ($char < 65 || $char > 90 && $char < 97 || $char > 122) {
            array_push($response, $str[$i]);
        } else if ($char > 77 && $char <= 90 || $char > 109 && $char <= 122) {
            array_push($response, fromCharCode(charCodeAt($str, $i) - 13));
        } else {
            array_push($response, fromCharCode(charCodeAt($str, $i) + 13));
        }
    }
    return join("", $response);
}

$encryptedString = "Uryyb Jbeyq";
$decryptedString = rot13($encryptedString);
consoleLog($decryptedString);

