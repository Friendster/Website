<?php
//var_dump(openssl_get_md_methods(true));

$alg = "AES-256-CBC";
$key = "ThisIsASecretKey12345678";

function encrypt($message, $iv)
{
    global $alg, $key;

    $iv_decoded = base64_decode($iv);
    $encrypted = openssl_encrypt($message, $alg, $key, OPENSSL_RAW_DATA, $iv_decoded);
    return base64_encode($encrypted);
}


function decrypt($encrypted, $iv)
{
    global $alg, $key;

    $iv_decoded = base64_decode($iv);
    $decoded = base64_decode($encrypted);
    return $decrypted = openssl_decrypt($decoded, $alg, $key, OPENSSL_RAW_DATA, $iv_decoded);
}

function generate_iv()
{
    global $alg;

    $iv_len = openssl_cipher_iv_length($alg);
    return base64_encode(openssl_random_pseudo_bytes($iv_len));
}