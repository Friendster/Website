<?php

//var_dump(openssl_get_md_methods(true));

class EncryptionManager {
    private static $alg = "AES-256-CBC";
    private static $key = "ThisIsASecretKey12345678";

    public static function encrypt($message, $iv) {
        $iv_decoded = base64_decode($iv);
        $encrypted = openssl_encrypt($message, EncryptionManager::$alg, EncryptionManager::$key, OPENSSL_RAW_DATA, $iv_decoded);
        return base64_encode($encrypted);
    }

    public static function decrypt($encrypted, $iv) {
        $iv_decoded = base64_decode($iv);
        $decoded = base64_decode($encrypted);
        return $decrypted = openssl_decrypt($decoded, EncryptionManager::$alg, EncryptionManager::$key, OPENSSL_RAW_DATA, $iv_decoded);
    }

    public static function generateIv() {
        $iv_len = openssl_cipher_iv_length(EncryptionManager::$alg);
        return base64_encode(openssl_random_pseudo_bytes($iv_len));
    }

    public static function generateNameFromIv() {
        $iv_len = openssl_cipher_iv_length(EncryptionManager::$alg);
        return bin2hex(openssl_random_pseudo_bytes($iv_len));
    }
}
