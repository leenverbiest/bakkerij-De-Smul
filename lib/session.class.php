<?php
/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 9/02/2017
 * Time: 18:48
 */
class Session{

    protected static $flash_message;

    public static function setFlash($message){
        self::$flash_message=$message;
    }
    public static function hasFlash(){
        return !is_null(self::$flash_message);
    }
    public static function flash(){
        return self::$flash_message;

    }
    public static function unFlash(){
        self::$flash_message=null;
    }
    public static function set($key,$value){
        $_SESSION[$key]=$value;
    }
    public static function get($key){
        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return null;
    }
    public static function delete($key){
        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }
    public static function destroy(){
        session_destroy();
    }
}