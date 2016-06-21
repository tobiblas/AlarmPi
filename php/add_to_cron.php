<?php
    $value = $_GET['value'];

    $command = 'echo "' . $value .'" > /var/www/html/alarm/crontab.txt';
    echo exec($command . ' 2>&1');

?>