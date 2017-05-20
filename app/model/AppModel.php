<?php


class AppModel {

    public function getStyle() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $host = Config::$host;
        $port = (!empty(Config::$port)) ? ':' . Config::$port : '';
        $customPath = ($host === 'localhost') ? Config::$path : '';

        $link = $protocol . $host . $port . $customPath . '/public/assets/css/mystyle.css';

        return $link;
    }
}