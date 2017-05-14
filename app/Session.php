<?php

class Session
{

    public function __construct()
    {
        session_start();
    }


    public function get($property)
    {
        return isset($_SESSION[$property]) ? $_SESSION[$property] : null;
    }

    public function set($property, $value)
    {
        $_SESSION[$property] = $value;
    }

    public function tryRegenerateSession()
    {
        //$moo =

        //Regenerate session every 5 minutes
        if (null == $this->get( Properties::CREATED)) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > 300) {
            // session started more than 5 minutes ago
            session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
            $_SESSION['CREATED'] = time();  // update creation time
        }
    }

    public function tryDestroySession()
    {
        //Destroy session if last activity was 10 minutes ago
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
            // last request was more than 10 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session data in storage
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    }
}

abstract  class Properties{
    const ID = 'ID';
    const EMAIL = 'EMAIL';
    const TOKEN = 'TOKEN';
    const CREATED = 'CREATED';
    const LAST_ACTIVITY = 'LAST_ACTIVITY';
}
