<?php

    #THIS FILE IS CALLED ON THE MASTER PI UNIT (ALARM CENTRAL)

    $triggerID = $_GET['triggerID'];
    include("config.php");


    $subject = "ALARM TRIGGERED. Detector: " . $triggerID;
    $external = $config['externalIP'];
    $content = "Check alarm status here: http://" . trim($external) . "/alarm";

    if ($config['mail'] == null || $config['mail'] == 'true') {

        $emails = explode(';', $config['emails']);
        foreach($emails as $address) {
            $address = trim($address);
            //this is an ugly hack. Only have camera in kitchen so hardcode to kitchen for now.
            if ($triggerID == 'Kitchen') {
                shell_exec('echo "' . $content . '" | mail -s "' . $subject . '" ' . $address . ' -A ' . '/var/www/html/photos/$(ls /var/www/html/photos/ -t | head -n1)' );
            } else {
                shell_exec('echo "' . $content . '" | mail -s "' . $subject . '" ' . $address);
            }
        }
    }
?>
