<?php
namespace Codenest\Library ;

class Session
{
    protected static $flash_message;
    protected static $is_logged_in = false;

    public static function setFlash($message)
    {
        //self::$flash_message = $message ;
        $_SESSION['message'] = $message;
    }

    public static function hasFlash()
    {
        //return !is_null(self::$flash_message);
        return isset($_SESSION['message']);
    }

    public static function flash()
    {
        if (self::hasFlash()) {
            echo '<div class="alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
        }
        //self::$flash_message = null ;
        self::delete('message');
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function setBasket($key, $value)
    {
        array_push($_SESSION[$key], $value);
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function sessionSet($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    //clear certain items from the session
    public static function refresh()
    {
        self::delete('basket');
        self::delete('patient');
        self::delete('mar_drugs');
    }

    public static function destroy()
    {
        session_destroy();
    }
}
