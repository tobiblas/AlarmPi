<?php
    include("config.php");
    $enable = $_GET['enable'];
    
    $myfile = fopen($config['alarm_home'] . "ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
    }
    
    if ($enable == "false") {
        $alarm_on = true;
    } else if ($enable == "true") {
        $alarm_on = false;
    }
    
    $file = fopen($config['alarm_home'] . 'ALARMSTATUS.txt',"w");
    if ($alarm_on) {
        fwrite($file,'ALARM_ON: false');
    } else {
        fwrite($file,'ALARM_ON: true');
    }
    fclose($file);
    
    if ($alarm_on == false) {
        file_put_contents($config['alarm_home'] . "ALARMTRIGGERED.txt", "");
        file_put_contents($config['alarm_home'] . 'ALARMTRIGGERED.txt', "time#triggerid".PHP_EOL , FILE_APPEND);
    }
?>