<?php
    $out = array();
    $command = 'cat crontab.txt';
    exec($command . ' 2>&1', $out);
    foreach($out as $line) {
        $line = str_replace("wget -qO- localhost/alarm/toggle_alarm.php?enable=true &> /dev/null", "ON", $line);
        $line = str_replace("wget -qO- localhost/alarm/toggle_alarm.php?enable=false &> /dev/null", "OFF", $line);
        echo $line . PHP_EOL;
    }
?>
