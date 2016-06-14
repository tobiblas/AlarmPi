<?php
    $value = $_GET['value'];

    $command = '"' . $value .'" >> /var/www/html/alarm/newcronrows.txt';
    exec($command . ' 2>&1');

?>