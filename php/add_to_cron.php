<?php
    $value = $_GET['value'];

    $command = '"' . $value .'" >> /var/www/html/alarm/crontab.txt';
    exec($command . ' 2>&1');

?>