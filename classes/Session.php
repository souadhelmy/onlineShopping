<?php 

namespace OnlineShoping\Session;

class Session{
    // start the session
    public function __construct()
    {
        session_start();
    }

    // get the session with key
    public function get($key){
        return isset($_SESSION[$key])? $_SESSION[$key] : null;
    }

    //set session with key and value
    public function set($key , $value){
        $_SESSION[$key] = $value;
    }


    public function exist($key){
        return isset($_SESSION[$key]);
    }
    // unset the session
    public function remove($key){
        unset($_SESSION[$key]);
    }
}

?>