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

function sieveOfEratosthenes($n)
{
    $primes = [];
    for($i=0;$i<$n+1;$i++)
    {
        $primes[$i] = true;
    }
    $primes[0] = $primes[1] = false;
    $sqrtn = ceil(sqrt($n));
    for ($i = 2;
         $i <= $sqrtn; $i++) {
        if ($primes[$i]) {
            for ($j = 2 * $i;
                 $j <= $n; $j += $i) {
                $primes[$j] = false;
            }
        }
    }
    return $primes;
}

function main()
{
    $n = 69;
    $primes = sieveOfEratosthenes($n);
    for ($i = 2;
         $i <= $n; $i++) {
        if ($primes[$i]) {
            consoleLog($i);
        }
    }
}

main();

