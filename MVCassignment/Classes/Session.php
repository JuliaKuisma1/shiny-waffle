<?php
class Session
{
    public function __set($key, $val)
    {
        $_SESSION[$key] = $val;
    }
    public function __get($key)
    {
        return $_SESSION[$key];
    }
}
