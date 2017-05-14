<?php

class Session {

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
        if (null == $this->get(Properties::CREATED)) {
            $this->set(Properties::CREATED, time());
        } else if (time() - $this->get(Properties::CREATED) > 300) {
            // session started more than 5 minutes ago
            session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
            $this->set(Properties::CREATED, time());  // update creation time
        }
    }

    public function tryDestroySession() {

        //Destroy session if last activity was 10 minutes ago
        if (null != $this->get(Properties::LAST_ACTIVITY) && (time() - $this->get(Properties::LAST_ACTIVITY) > 600)) {
            // last request was more than 10 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session data in storage
        }
        $this->set(Properties::LAST_ACTIVITY, time()); // update last activity time stamp
    }

    public function login($profile) {
        $this->set(Properties::ID, $profile->id);
        $this->set(Properties::NAME, $profile->name);
        $this->set(Properties::EMAIL, $profile->email);
        $this->set(Properties::PROFILE_PICTIRE_NAME, $profile->profile_picture_name);

        navigate_to();
    }

    public function logout() {

        // TODO why are we giving a new array?
        $_SESSION = array();
        session_destroy();

        navigate_to();
    }

    public function printSession() {
        echo Properties::ID . ' = ' . $this->get(Properties::ID) . '<br>';
        echo Properties::EMAIL . ' = ' . $this->get(Properties::EMAIL) . '<br>';
        echo Properties::NAME . ' = ' . $this->get(Properties::NAME) . '<br>';
        echo Properties::PROFILE_PICTIRE_NAME . ' = ' . $this->get(Properties::PROFILE_PICTIRE_NAME) . '<br>';
        echo Properties::TOKEN . ' = ' . $this->get(Properties::TOKEN) . '<br>';
        echo Properties::CREATED . ' = ' . $this->get(Properties::CREATED) . '<br>';
        echo Properties::LAST_ACTIVITY . ' = ' . $this->get(Properties::LAST_ACTIVITY) . '<br>';
    }
}

// TODO move to a different file
abstract class Properties {
    const ID = 'ID';
    const EMAIL = 'EMAIL';
    const NAME = 'NAME';
    const PROFILE_PICTIRE_NAME = 'PROFILE_PICTIRE_NAME';
    const TOKEN = 'TOKEN';
    const CREATED = 'CREATED';
    const LAST_ACTIVITY = 'LAST_ACTIVITY';
}
