<?php
    include("config.php");
    
    $sound = $_GET['sound'];
    $sms = $_GET['sms'];
    $phoneNumbers = $_GET['phoneNumbers'];
    $mail = $_GET['mail'];
    $emails = $_GET['emails'];
    $logwhenoff = $_GET['logwhenoff'];
    
    #todo: set the value parsed. Below if copy pasted.
    
    $myfile = fopen($alarm_path . "ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
    }
    
    $file = fopen($alarm_path . 'ALARMSTATUS.txt',"w");
    if ($alarm_on) {
        fwrite($file,'ALARM_ON: false');
    } else {
        fwrite($file,'ALARM_ON: true');
    }
    fclose($file);
    
    if ($alarm_on == false) {
        file_put_contents($alarm_path . "ALARMTRIGGERED.txt", "");
        file_put_contents($alarm_path . 'ALARMTRIGGERED.txt', "time#triggerid".PHP_EOL , FILE_APPEND);
    } else {
        #stop application
        shell_exec('sudo adb shell am force-stop com.tobiblas.alarmpusher');
    }
?>