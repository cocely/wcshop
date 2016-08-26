<?php

defined("BASE_PATH") OR exit("No direct script access allowed");

class Session
{
    public function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
    }

    public function get_session($session_key)
    {
        return $_SESSION[$session_key];
    }

    public function set_session($session_key, $session_value)
    {
        $_SESSION[$session_key] = $session_value;
    }

    public function has_session($session_key)
    {
        if(isset($_SESSION[$session_key]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function clear_all_sessions()
    {
        session_destroy();
    }
}
