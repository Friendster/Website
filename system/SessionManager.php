<?php

class SessionManager {

    public function __construct() {
        session_start();
    }

    public function get($property) {
        return isset($_SESSION[$property]) ? htmlentities($_SESSION[$property]) : null;
    }

    public function set($property, $value) {
        $_SESSION[$property] = $value;
    }

    public function tryRegenerateSession() {
        //Regenerate session every 5 minutes
        if (null == $this->get(Session::CREATED)) {
            $this->set(Session::CREATED, time());
        } else if ((time() - $this->get(Session::CREATED) > 100) && $this->get(Session::EMAIL) != 'cma') {
            echo $this->get(Session::NAME);
            // session started more than 5 minutes ago
            session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
            $this->set(Session::CREATED, time());  // update creation time
        }
    }

    public function tryDestroySession() {

        //Destroy session if last activity was 10 minutes ago
        if (null != $this->get(Session::LAST_ACTIVITY) && (time() - $this->get(Session::LAST_ACTIVITY) > 600) && $this->get(Session::EMAIL) != 'cma') {

            // last request was more than 10 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session entities in storage
        }
        $this->set(Session::LAST_ACTIVITY, time()); // update last activity time stamp
    }

    public function login($profile) {
        $this->set(Session::ID, $profile->id);
        $this->set(Session::NAME, $profile->name);
        $this->set(Session::EMAIL, $profile->email);
        $this->set(Session::PROFILE_PICTIRE_NAME, $profile->profile_picture_name);

        navigate();
    }

    public function logout() {

        // TODO why are we giving a new array?
        $_SESSION = array();
        session_destroy();

        navigate();
    }

    public function isLoggedIn() {
        return ($this->get(Session::ID) != null);
    }

    public function printSession() {
        echo Session::ID . ' = ' . $this->get(Session::ID) . '<br>';
        echo Session::EMAIL . ' = ' . $this->get(Session::EMAIL) . '<br>';
        echo Session::NAME . ' = ' . $this->get(Session::NAME) . '<br>';
        echo Session::PROFILE_PICTIRE_NAME . ' = ' . $this->get(Session::PROFILE_PICTIRE_NAME) . '<br>';
        echo Session::TOKEN . ' = ' . $this->get(Session::TOKEN) . '<br>';
        echo Session::CREATED . ' = ' . $this->get(Session::CREATED) . '<br>';
        echo Session::LAST_ACTIVITY . ' = ' . $this->get(Session::LAST_ACTIVITY) . '<br>';
    }
}