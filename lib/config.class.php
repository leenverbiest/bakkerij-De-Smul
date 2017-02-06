<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 13:40
 */

class Config
{
    protected static $settings=array();

    public static function get($key)
    {
        return isset(self::$settings[$key])?self::$settings[$key]:null;
    }

    public static function set($key,$value)
    {
        self::$settings[$key]=$value;
    }


}