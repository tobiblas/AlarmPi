<?php
    
    #THIS FILE IS CALLED ON THE MASTER PI UNIT (ALARM CENTRAL)
    #CALLING THIS FROM ANY UNIT TELLS THE SERVER THAT SOMETHING
    #HAS BEEN DETECTED. THIS SCRIPT RESPONDS WITH IF THE ALARM
    # IS ON OR NOT AN LOGS THE MOTION.
 
    $triggerID = $_GET['triggerID'];
    include("config.php");

    $alarmstriggered = file_get_contents($config['alarm_home'] . "ALARMTRIGGERED.txt");
    date_default_timezone_set('Europe/Stockholm');
    $date = date('d/m/Y H:i:s', time());
    $txt = $date . "#" . ($triggerID);
    
    if (strpos($alarmstriggered,$triggerID) !== false) {
        //do nothing
    } else {
        file_put_contents($config['alarm_home'] . 'ALARMTRIGGERED.txt', $txt.PHP_EOL , FILE_APPEND);
    }
    
    $myfile = fopen($config['alarm_home'] . "ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
        $txt = $txt . '#' . 'On';
    } else {
         $txt = $txt . '#' . 'Off';
    }
    
    $log_when_off = $config['logwhenoff'] == 'true' || $config['logwhenoff'] == NULL;
    
    if ($log_when_off || $alarm_on) {
        file_put_contents($config['alarm_home'] . 'ALARMLOG.txt', $txt.PHP_EOL , FILE_APPEND);
    }
    
    
    if ($alarm_on) {
        echo "ALARMON";
    } else {
        echo "ALARMOFF";
    }
?>
