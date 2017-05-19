<?php

/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 15-May-17
 * Time: 1:31
 */
class ValidationManager {

    public static function validateRequired($value) {
        $error = '';
        if (empty($value)) {
            $error = 'is required';
        }

        return $error;
    }

    public static function validatePassword($password) {
        $error = ValidationManager::validateRequired($password);

        if (!ValidationManager::isValid($error)) {}
        elseif(strlen($password) < '8') {
            $error = 'must contain at least 8 characters!';
        } elseif (!preg_match('#[0-9]+#', $password)) {
            $error = 'must contain at least 1 number!';
        } elseif (!preg_match('#[A-Z]+#', $password)) {
            $error = 'must contain at least 1 capital letter!';
        } elseif (!preg_match('#[a-z]+#', $password)) {
            $error = 'must contain at least 1 lowercase letter!';
        }

        return $error;
    }

    public static function validateEmail($email) {
        $error = ValidationManager::validateRequired($email);

        if (!ValidationManager::isValid($error)) {}
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'is NOT valid!';
        } // Check if user exists
        elseif (!empty($user = Database::getUser($email)->id)) {
            $error = 'has been registered';
        }

        return $error;
    }

    public static function validateRecaptcha($value) {
        $error = '';
        if (!RecaptchaManager::isRecaptchaValid($value)) {
            $error = 'Please validate recapcha';
        }

        return $error;
    }

    public static function isValid($error) {
        return empty($error);
    }


}