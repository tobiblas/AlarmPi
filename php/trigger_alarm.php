<?php
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
    
    file_put_contents($config['alarm_home'] . 'ALARMLOG.txt', $txt.PHP_EOL , FILE_APPEND);
    
    if ($alarm_on) {
        
        $subject = "Alarm when off. Detector: " . $triggerID;
        $external = $config['externalIP'];
        $content = "Check alarm status here: http://" . trim($external) . "/alarm";
        
        if ($config['mail'] == null || $config['mail'] == 'true') {
            
            $emails = explode(';', $config['emails']);
            foreach($emails as $address) {
                $address = trim($address);
                shell_exec('echo "' . $content . '" | mail -s "' . $subject . '" ' . $address);
            }
        }
        
        $sound = 'true';
        if ($config['sound'] != null) {
            $sound = $config['sound'];
        }
        $sms = 'true';
        if ($config['sms'] != null) {
            $sms = $config['sms'];
        }
        $phoneNumbers = "";
        if ($config['phoneNumbers'] != null) {
            $phoneNumbers = $config['phoneNumbers'];
        }

        $message = $subject . '\n' . $content;
        #start application
        shell_exec('sudo adb shell am start -a android.intent.action.VIEW -n com.tobiblas.alarmpusher/.MainActivity -e sound ' . $sound . ' -e sms ' . $sms . ' -e phonenumbers "' . $phoneNumbers . '" -e message "Hej tobiassssss"');
    }
?>