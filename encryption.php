<?php
    $iv = file_get_contents("/path/to/iv");
    $key = file_get_contents("/path/to/passphrase");
    
    function encrypt($data, $pass) {
        $encrypted = openssl_encrypt($data, "cipher-algo", $key.$pass, 0, $iv);
        return $encrypted;
    }
    
    function decrypt($data, $pass) {
        $decrypted = openssl_decrypt($data, "cipher-algo", $key.$pass, 0, $iv);
        return $decrypted;
    }
?>