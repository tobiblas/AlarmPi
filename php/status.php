<div class="row">
<div class="col-12">
<p style="text-align: center;">Alarm status</p>
<div id="alarmsettings">

<?php
    include("config.php");
    $myfile = fopen($alarm_path . "ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
    }
    ?>

<div class="onoffswitch">
<input type="checkbox" onchange="toggle_alarm();" <?php if ($alarm_on) echo "checked"; ?> name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
<label class="onoffswitch-label" for="myonoffswitch">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>


</div>

</div>

</div>

<br/>


<?php
    
    # loop through all triggered alarms (might be several detectors) and print time and id
    
    if ($alarm_on) {
    
        $handle = fopen($alarm_path . "ALARMTRIGGERED.txt", "r");
        if ($handle) {
            $i = 1;
            while (($line = fgets($handle)) !== false) {
                if ($i == 1) {
                    $i++;
                    continue;
                } else {
                    
                    $pieces = explode("#", $line);
                    $time = $pieces[0];
                    $detectorID = $pieces[1];
                    echo "<hr/>";
                    echo "<div class='row' style='background-color:#FFa69D;'><div class='col-12'>";
                    echo "<br><p style='text-align: center;'>ALARM TRIGGERED " . $time . ". <br>DetectorID = " . $detectorID . "</p>";
                    echo "</div></div>";
                }
                $i++;
            }
            if ($i == 2) {
                echo "<div class='row'><div class='col-12'>";
                echo "<hr/>";
                echo "<br><p style='text-align: center;'>No alarms triggered</p>";
                echo "</div></div>";
            } else {
                echo "<hr/>";
            }
            fclose($handle);
        } else {
            echo "unable to open ALARMTRIGGERED.txt";
        }
    }
?>


</div>
</div>
