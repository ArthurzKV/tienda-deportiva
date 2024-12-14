<?php
use Firebase\JWT\JWT;

require 'vendor/autoload.php';

$key = "123";

function create_jwt($data) {
    global $key;
    return JWT::encode($data, $key, 'HS256');
}

function verify_jwt($token) {
    global $key;
    try {
        return JWT::decode($token, $key, ['HS256']);
    } catch (Exception $e) {
        return null;
    }
}
?>
