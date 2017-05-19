<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 15-Apr-17
 * Time: 13:03
 */

class RecaptchaManager {
    public static function isRecaptchaValid($response) {
        $secret = Config::$recaptchaSecret;
        $url = Config::$recaptchaUrl;

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

        return (Config::host != "localhost") ? $captcha_success->success : true;
    }
}