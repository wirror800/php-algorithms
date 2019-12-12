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

/******************************************************
Find and retrieve the encryption key automatically
Note: This is a draft version, please help to modify, Thanks!
 ******************************************************/
function keyFinder($str)
{
    $wordbank = array("I ", "You ", "We ", "They ", "He ", "She ", "It ", " the ", "The ", " of ", " is ", "Is ", " am ", "Am ", " are ", "Are ", " have ", "Have ", " has ", "Has ", " may ", "May ", " be ", "Be ");
    $inStr = strval($str);
    $outStr = "";
    $outStrElement = "";
    for ($k = 0;
         $k < 26; $k++) {
        $outStr = caesarCipherEncodeAndDecodeEngine($inStr, $k);
        for ($s = 0;
             $s < count($outStr); $s++) {
            for ($i = 0;
                 $i < count($wordbank); $i++) {
                for ($w = 0;
                     $w < count($wordbank[$i]); $w++) {
                    $outStrElement += $outStr[$s + $w];
                }
                if ($wordbank[$i] == $outStrElement) {
                    return $k;
                }
                $outStrElement = "";
            }
        }
    }
    return 0;
}

/* this sub-function is used to assist the keyfinder to find the key */
function caesarCipherEncodeAndDecodeEngine($inStr, $numShifted)
{
    $shiftNum = $numShifted;
    $charCode = 0;
    $outStr = "";
    $shftedcharCode = 0;
    $result = 0;
    for ($i = 0;
         $i < count($inStr); $i++) {
        $charCode = charCodeAt($inStr, $i);
        $shftedcharCode = $charCode + $shiftNum;
        $result = $charCode;
        if ($charCode >= 48 && $charCode <= 57) {
            if ($shftedcharCode < 48) {
                $diff = abs(48 - 1 - $shftedcharCode) % 10;
                while ($diff >= 10) {
                    $diff = $diff % 10;
                }
                consoleLog($diff);
                $shftedcharCode = 57 - $diff;
                $result = $shftedcharCode;
            } else if ($shftedcharCode >= 48 && $shftedcharCode <= 57) {
                $result = $shftedcharCode;
            } else if ($shftedcharCode > 57) {
                $diff = abs(57 + 1 - $shftedcharCode) % 10;
                while ($diff >= 10) {
                    $diff = $diff % 10;
                }
                consoleLog($diff);
                $shftedcharCode = 48 + $diff;
                $result = $shftedcharCode;
            }
        } else if ($charCode >= 65 && $charCode <= 90) {
            if ($shftedcharCode <= 64) {
                $diff = abs(65 - 1 - $shftedcharCode) % 26;
                while ($diff % 26 >= 26) {
                    $diff = $diff % 26;
                }
                $shftedcharCode = 90 - $diff;
                $result = $shftedcharCode;
            } else if ($shftedcharCode >= 65 && $shftedcharCode <= 90) {
                $result = $shftedcharCode;
            } else if ($shftedcharCode > 90) {
                $diff = abs($shftedcharCode - 1 - 90) % 26;
                while ($diff % 26 >= 26) {
                    $diff = $diff % 26;
                }
                $shftedcharCode = 65 + $diff;
                $result = $shftedcharCode;
            }
        } else if ($charCode >= 97 && $charCode <= 122) {
            if ($shftedcharCode <= 96) {
                $diff = abs(97 - 1 - $shftedcharCode) % 26;
                while ($diff % 26 >= 26) {
                    $diff = $diff % 26;
                }
                $shftedcharCode = 122 - $diff;
                $result = $shftedcharCode;
            } else if ($shftedcharCode >= 97 && $shftedcharCode <= 122) {
                $result = $shftedcharCode;
            } else if ($shftedcharCode > 122) {
                $diff = abs($shftedcharCode - 1 - 122) % 26;
                while ($diff % 26 >= 26) {
                    $diff = $diff % 26;
                }
                $shftedcharCode = 97 + $diff;
                $result = $shftedcharCode;
            }
        }
        $outStr = $outStr + fromCharCode(intval($result));
    }
    return $outStr;
}

