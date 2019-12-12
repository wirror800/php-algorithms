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

/**
 * Class FlashSort
 * ref: https://www.neubert.net/Flacodes/FLACodes.html
 */
class FlashSort
{
    /**
     * Partial flash sort
     */
    public static function Sort($a)
    {
        $n = count($a);
        $m = ~~(0.45 * $n);
        $l = [];

        $anmin = $a[0];
        $nmax  = 0;


        for ($i=1; $i < $n; $i++)
        {
            if ($a[$i] < $anmin) $anmin=$a[$i];
            if ($a[$i] > $a[$nmax]) $nmax=$i;
        }

        if ($anmin == $a[$nmax]) return $a;


        $c1 = ($m - 1)/($a[$nmax] - $anmin);

        for($i=0; $i<$m; $i++)
        {
            $l[$i] = 0;
        }

        for ($i=0; $i < $n; $i++)
        {
            $k = ~~($c1*($a[$i] - $anmin));
            $l[$k]++;
        }

        for ($k=1; $k < $m; $k++)
        {
            $l[$k] += $l[$k-1];
        }

        $hold = $a[$nmax];
        $a[$nmax]=$a[0];
        $a[0]=$hold;

        $nmove = 0;
        $j=0;
        $k=$m-1;

        while ($nmove < $n-1)
        {
            while ($j > ($l[$k]-1))
            {
                $j++;
                $k = ~~($c1 * ($a[$j] - $anmin));
            }
            if ($k < 0) break;

            $flash = $a[$j];

            while (!($j == $l[$k]))
            {
                $k = ~~ ($c1 * ($flash - $anmin));

                $hold = $a[$l[$k]-1];
                $a[$l[$k]-1]=$flash;
                $flash = $hold;


                $l[$k]--;
                $nmove++;
            }

            // insertion
            for ($j = 1; $j < $n; $j++)
            {
                $hold = $a[$j];
                $i = $j - 1;
                while ($i >= 0 && $a[$i] > $hold) {
                    $a[$i + 1] = $a[$i--];
                }
                $a[$i + 1] = $hold;
            }
        }

        return $a;
    }
}

$array = array(3, 0, 2, 5, -1, 4, 1, -2);
consoleLog("-----before sorting-----");
consoleLog($array);
consoleLog("-----after sorting-----");
consoleLog(FlashSort::Sort($array));

