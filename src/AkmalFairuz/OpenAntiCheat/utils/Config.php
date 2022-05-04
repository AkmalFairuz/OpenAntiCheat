<?php

declare(strict_types=1);

namespace AkmalFairuz\OpenAntiCheat\utils;

use function array_merge;
use function is_array;
use function yaml_parse_file;

class Config{

    private static array $config = [];

    public static function load(string $path) : void{
        $cfg = yaml_parse_file($path);
        foreach($cfg as $key => $val) {
            if(is_array($val)) {
                self::$config = array_merge(self::$config, self::parseNested($key, $val));
            }else{
                self::$config[$key] = $val;
            }
        }
    }

    private static function parseNested(string $key, array $array) : array {
        $ret = [];
        foreach($array as $k => $v) {
            if(is_array($v)) {
                $ret = array_merge($ret, self::parseNested($key . "." . $k, $v));
            }else{
                $ret[$key . "." . $k] = $v;
            }
        }
        return $ret;
    }

    public static function get(string $key, mixed $default = null) : mixed{
        return self::$config[$key] ?? $default;
    }
}