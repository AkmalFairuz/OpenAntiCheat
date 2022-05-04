<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\utils;

class Utils{

    public static function strArray(array $array): string{
        $ret = "(";
        foreach($array as $k => $v) {
            if($ret !== "(") {
                $ret .= ", ";
            }
            $ret .= "$k=$v";
        }
        $ret .= ")";
        return $ret;
    }
}