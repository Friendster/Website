<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 15-Apr-17
 * Time: 13:03
 */

function is_recapcha_valid($response) {
    $secret = "6LcpFBoUAAAAALNJMzRqz3XcQHW3XHl_IpC11xeU";

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secret,
        'response' => $response
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? $captcha_success->success : true;
//    return true;
}
