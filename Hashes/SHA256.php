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

class SHA256
{
    private $blocksize = 16;
    private $k = array(
        0x428a2f98, 0x71374491, 0xb5c0fbcf, 0xe9b5dba5, 0x3956c25b, 0x59f111f1, 0x923f82a4, 0xab1c5ed5,
        0xd807aa98, 0x12835b01, 0x243185be, 0x550c7dc3, 0x72be5d74, 0x80deb1fe, 0x9bdc06a7, 0xc19bf174,
        0xe49b69c1, 0xefbe4786, 0x0fc19dc6, 0x240ca1cc, 0x2de92c6f, 0x4a7484aa, 0x5cb0a9dc, 0x76f988da,
        0x983e5152, 0xa831c66d, 0xb00327c8, 0xbf597fc7, 0xc6e00bf3, 0xd5a79147, 0x06ca6351, 0x14292967,
        0x27b70a85, 0x2e1b2138, 0x4d2c6dfc, 0x53380d13, 0x650a7354, 0x766a0abb, 0x81c2c92e, 0x92722c85,
        0xa2bfe8a1, 0xa81a664b, 0xc24b8b70, 0xc76c51a3, 0xd192e819, 0xd6990624, 0xf40e3585, 0x106aa070,
        0x19a4c116, 0x1e376c08, 0x2748774c, 0x34b0bcb5, 0x391c0cb3, 0x4ed8aa4a, 0x5b9cca4f, 0x682e6ff3,
        0x748f82ee, 0x78a5636f, 0x84c87814, 0x8cc70208, 0x90befffa, 0xa4506ceb, 0xbef9a3f7, 0xc67178f2
    );
    private $h = array(
        0x6a09e667, 0xbb67ae85, 0x3c6ef372, 0xa54ff53a, 0x510e527f, 0x9b05688c, 0x1f83d9ab, 0x5be0cd19
    );
    private $w = array();
    private $x = array();
    private $length = 0;
    private $terminated = false;
    private $size = false;

    static function make($data, $raw = false)
    {
        $sha256 = new SHA256();
        $data = unpack('H*', $data);
        $data = $data[1];
        $sha256->x = $sha256->h;
        $i = 0;
        do{
            $start = $i << 7;
            $block = substr($data, $start, $sha256->blocksize << 3);
            $sha256->push($block);
            $i++;
        }while(!($sha256->terminated && $sha256->size));
        return $sha256->finalize($raw);
    }

    static function hmac($data, $key, $raw = false)
    {
        if(strlen($key) < 64) {
            $key = str_pad($key, 64, chr(0));
        } elseif(strlen($key) > 64) {
            $key = str_pad(SHA256::make($key, true), 64, chr(0));
        }
        $key = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $md = SHA256::make($key . $data, true);
        $key = (substr($key, 0, 64) ^ str_repeat(chr(0x36) ^ chr(0x5c), 64));
        return SHA256::make($key . $md, $raw);
    }

    function push($data)
    {
        $length = strlen($data) >> 1;
        $length = ($length >> 2) + (($length & 0x03) ? 1 : 0);
        $len = 0;
        for($i = 0; $i < $length; $i++) {
            $hex = substr($data, $i << 3, 8);
            $len = strlen($hex);
            $this->length += $len << 2;
            $this->w[$i] = hexdec($hex);
        }
        if(($len > 0) && ($len < 8)){
            $this->w[$i - 1] = ($this->w[$i - 1] << (32 - ($len << 2))) | (0x80000000 >> ($len << 2));
            $this->terminated = true;
        } else if(!$this->terminated && ($i < 16)){
            $this->w[$i++] = 0x80000000;
            $this->terminated = true;
        }
        while($i < 14) {
            $this->w[$i++] = 0;
        }
        if($i === 14) {
            $this->w[$i++] = ($this->length >> 32) & 0xFFFFFFFF;
            $this->w[$i++] = $this->length & 0xFFFFFFFF;
            $this->size = true;
        }
        while($i < 16) {
            $this->w[$i++] = 0;
        }
        $this->round();
        return $length;
    }

    function finalize($raw = false)
    {
        $hash = "";
        foreach($this->x as $x) {
            $hash.= substr("000000" . dechex($x & 0xffffffff), -8, 8);
        }
        return $raw ? hex2bin($hash) : $hash;
    }

    function round()
    {
        $x = array();
        foreach($this->x as $i => $value) {
            $x[$i] = $value;
        }
        for($i = 16; $i < 64; $i++) {
            $this->w[$i] = (SHA256::S256S1($this->w[$i - 2])
                    + $this->w[$i - 7]
                    + SHA256::S256S0($this->w[$i - 15])
                    + $this->w[$i - 16]) & 0xFFFFFFFF;
        }
        for($i = 0; $i < 64; $i++) {
            $t1 = ($x[7]
                    + SHA256::S256L1($x[4])
                    + SHA256::CH($x[4], $x[5], $x[6])
                    + $this->k[$i]
                    + $this->w[$i]) & 0xffffffff;
            $t2 = (SHA256::S256L0($x[0]) + SHA256::MAJ($x[0], $x[1], $x[2])) & 0xffffffff;
            $x[7] = $x[6];
            $x[6] = $x[5];
            $x[5] = $x[4];
            $x[4] = ($x[3] + $t1) & 0xffffffff;
            $x[3] = $x[2];
            $x[2] = $x[1];
            $x[1] = $x[0];
            $x[0] = ($t1 + $t2) & 0xffffffff;
        }
        foreach($x as $i => $value) {
            $this->x[$i] += $value;
        }
    }

    function SHR($n, $x)
    {
        $mask = (1 << (32 - $n)) - 1;
        return ($x >> $n) & $mask;
    }

    function ROTR($n, $x)
    {
        return SHA256::SHR($n, $x) | ((($x) << (32 - $n)) & 0xFFFFFFFF);
    }

    function CH($x, $y, $z)
    {
        return ($x & $y) ^ (~$x & $z);
    }

    function MAJ($x, $y, $z)
    {
        return (($x & $y) ^ ($x & $z) ^ ($y & $z));
    }

    function S256L0($x)
    {
        return (SHA256::ROTR(2, $x) ^ SHA256::ROTR(13,$x) ^ SHA256::ROTR(22, $x));
    }

    function S256L1($x)
    {
        return (SHA256::ROTR(6, $x) ^ SHA256::ROTR(11, $x) ^ SHA256::ROTR(25, $x));
    }

    function S256S0($x)
    {
        return (SHA256::ROTR(7, $x) ^ SHA256::ROTR(18, $x) ^ SHA256::SHR(3, $x));
    }

    function S256S1($x)
    {
        return (SHA256::ROTR(17, $x) ^ SHA256::ROTR(19, $x) ^ SHA256::SHR(10, $x));
    }
}

consoleLog(SHA256::make("A Test"));

