<?php
    $command = 'cat crontab.txt';
    echo exec($command . ' 2>&1');
?>
