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

function isLetter($str)
{
    return stringLength($str) === 1 && preg_match('/[a-zA-Z]/i', $str);
}

function isUpperCase($character)
{
    if ($character == strtoupper($character)) {
        return true;
    }
    if ($character == strtolower($character)) {
        return false;
    }
}

function encrypt($message, $key)
{
    $result = "";
    for ($i = 0,$j = 0;
         $i < stringLength($message);
         $i++)
    {
        $c = $message[$i];
        if (isLetter($c)) {
            if (isUpperCase($c)) {
                $result .= fromCharCode((charCodeAt($c,0) + charCodeAt(strtoupper($key), $j) - 2 * 65) % 26 + 65);
            } else {
                $result .= fromCharCode((charCodeAt($c,0) + charCodeAt(strtolower($key), $j) - 2 * 97) % 26 + 97);
            }
        } else {
            $result .= $c;
        }
        $j = (++$j) % stringLength($key);
    }
    return $result;
}

function decrypt($message, $key)
{
    $result = "";
    for ($i = 0,$j = 0;
         $i < stringLength($message);
         $i++)
    {
        $c = $message[$i];
        if (isLetter($c)) {
            if (isUpperCase($c)) {
                $result .= fromCharCode(90 - (25 - charCodeAt($c,0) + charCodeAt(strtoupper($key),$j)) % 26);
            } else {
                $result .= fromCharCode(122 - (25 - charCodeAt($c,0) + charCodeAt(strtolower($key),$j)) % 26);
            }
        } else {
            $result .= $c;
        }
        $j = (++$j) % stringLength($key);
    }
    return $result;
}

$messageEncrypt = encrypt('Hello World!', 'code');
consoleLog($messageEncrypt);
$messageDecrypt = decrypt('Jsopq Zstzg!', 'code');
consoleLog($messageDecrypt);

