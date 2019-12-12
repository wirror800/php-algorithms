<?php
/**
 * Created by PhpStorm.
 * User: chelun
 * Date: 2019/12/11
 * Time: 3:08 PM
 */
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

    echo "$output \n";
}