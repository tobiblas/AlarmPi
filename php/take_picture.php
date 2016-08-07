<?php
    $command = '/var/www/html/alarm/take_picture.php';
    echo exec($command . ' 2>&1');
?>
