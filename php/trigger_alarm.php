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
    
    if ($alarm_on) {
        #Check properties for sms, phonenumber, sound and pass parameters to below:

        #stop application
        shell_exec('sudo adb shell am force-stop com.tobiblas.alarmpusher');
        
        #start application
        shell_exec('sudo adb shell am start -a android.intent.action.VIEW -n com.tobiblas.alarmpusher/.MainActivity -e sound true -e sms false -e phonenumbers "+46760732005" -e message "Hej tobiassssss"');
    }
?>