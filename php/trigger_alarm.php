<?php
    $triggerID = $_GET['triggerID'];
    include("config.php");

    $alarmstriggered = file_get_contents($alarm_path . "ALARMTRIGGERED.txt");
    date_default_timezone_set('Europe/Stockholm');
    $date = date('d/m/Y H:i:s', time());
    $txt = $date . "#" . ($triggerID);
    
    if (strpos($alarmstriggered,$triggerID) !== false) {
        //do nothing
    } else {
        file_put_contents($alarm_path . 'ALARMTRIGGERED.txt', $txt.PHP_EOL , FILE_APPEND);
    }
    
    $myfile = fopen($alarm_path . "ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
        $txt = $txt . '#' . 'On';
    } else {
         $txt = $txt . '#' . 'Off';
    }
    
    file_put_contents($alarm_path . 'ALARMLOG.txt', $txt.PHP_EOL , FILE_APPEND);
?>