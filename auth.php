<?php
    
    include("config.php");
    $valid_user = $config['user'];
    $valid_pass = $config['password'];
    
    $user = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];
    
    $validated = ($user == $valid_user && $pass == $valid_password);
    
    if (!$validated) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Not authorized");
    }
?>
