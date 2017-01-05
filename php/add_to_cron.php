<?php
    $value = $_GET['value'];
    
    $value = str_replace("ON", "wget -qO- localhost/alarm/toggle_alarm.php?enable=true &> /dev/null", $value);
    $value = str_replace("OFF", "wget -qO- localhost/alarm/toggle_alarm.php?enable=false &> /dev/null", $value);

    $command = 'echo "' . $value .'" > /var/www/html/alarm/crontab.txt';
    echo exec($command . ' 2>&1');

?>