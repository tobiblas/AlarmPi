<?php
    $myfile = fopen("ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
    }
    
    $file = fopen('ALARMSTATUS.txt',"w");
    if ($alarm_on) {
        fwrite($file,'ALARM_ON: false');
    } else {
        fwrite($file,'ALARM_ON: true');
    }
    fclose($file);
    
    if ($alarm_on == false) {
        file_put_contents("ALARMTRIGGERED.txt", "");
        file_put_contents('ALARMTRIGGERED.txt', "time#triggerid".PHP_EOL , FILE_APPEND);
    }
?>