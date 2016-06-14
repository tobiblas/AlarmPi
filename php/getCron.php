<?php
    $out = array();
    $command = 'cat crontab.txt';
    exec($command . ' 2>&1', $out);
    foreach($out as $line) {
        echo $line . "<br/>";
    }
?>
