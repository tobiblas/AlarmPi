<?php
    if (isset($_GET['alarmon'])) {
        $alarm_on_filter = $_GET['alarmon'];
    }
    if (isset($_GET['alarmoff'])) {
        $alarm_off_filter = $_GET['alarmoff'];
    }
    
    include("config.php");
?>

<script>
function toggle_alarm_on()
{
    alarmOn = document.getElementById("alarmon").checked;
    window.location.href = swapOutParam(window.location.href, "alarmon", alarmOn);
}

function toggle_alarm_off()
{
    alarmOff = document.getElementById("alarmoff").checked;
    window.location.href = swapOutParam(window.location.href, "alarmoff", alarmOff);
}

function swapOutParam(url, paramName, newParamValue) {
    
    var newUrl = url;
    var afterQuestionMark = url.substr(url.indexOf('?') + 1, url.length);
    var beforeQuestionMark = url.substr(0, url.indexOf('?') - 1);
   
    if (afterQuestionMark != null && afterQuestionMark.indexOf(paramName) > -1) {
        //swap value;
        var params = afterQuestionMark.split("&");
        
        newUrl = beforeQuestionMark + "?";
        var first = true;
        for (var i = 0; i < params.length; ++i) {
            if (!first) {
                newUrl += "&";
            } else {
                first = false;
            }
            
            if (params[i].indexOf(paramName) > -1) {
                //this is the one we want to replace
                var paramToSwap = params[i].split("=");
                newUrl += paramToSwap[0] + "=" + newParamValue;
            } else {
                newUrl += params[i];
            }
        }
    } else {
        //addValue;
        if (url.indexOf("?") > -1) {
            newUrl += "&" + paramName + "=" + newParamValue;
        } else {
            newUrl = beforeQuestionMark + "?" + paramName + "=" + newParamValue;
        }
    }

    return newUrl;
}

</script>


<div class="row">
<div class="col-12">

<div style="text-align: center;" id="filters">

<div id="filtertitle">Alarm</div>
<input type="checkbox" onchange="toggle_alarm_on();" <?php if (strcmp($alarm_on_filter,'true') == 0) echo "checked"; ?> id="alarmon" name="alarmon" value="alarmon"> On<br>
<input type="checkbox" onchange="toggle_alarm_off();" <?php if (strcmp($alarm_off_filter, 'true') == 0) echo "checked"; ?> id="alarmoff" name="alarmoff" value="alarmoff"> Off<br>

</div>
<hr/>

<div id="logarea">

<?php
    $myfile = fopen($config['alarm_home'] . "ALARMSTATUS.txt", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_on = false;
    
    if (strpos($fileline,'true') !== false) {
        $alarm_on = true;
    }
    
    $logwhenoff = 'true';
    if ($config['logwhenoff'] != null) {
        $logwhenoff = $config['logwhenoff'];
    }
    
    if ($alarm_on == true || $logwhenoff == 'true') {
        $handle = fopen($config['alarm_home'] . "ALARMLOG.txt", "r");
        if ($handle) {
            $i = 1;
            $log_rows = array();
            while (($line = fgets($handle)) !== false) {
                if ($i == 1) {
                    $i++;
                    continue;
                } else {
                    
                    $pieces = explode("#", $line);
                    $time = $pieces[0];
                    $detectorID = $pieces[1];
                    $onOrOff = trim($pieces[2]);
                    
                    #                echo "[$onOrOff][$alarm_on_filter]";
                    
                    if (strcmp($onOrOff,'On') == 0 && strcmp($alarm_on_filter,'true') == 0 ||
                        strcmp($onOrOff,'Off') == 0 && strcmp($alarm_off_filter,'true') == 0) {
                        array_push($log_rows, "<div class='logrow' style='text-align: center;'>" . $time . " | DetectorID = " . $detectorID . " | AlarmStatus= " . $onOrOff . "</div>");
                    }
                    
                }
                $i++;
            }
            
            for($x = count($log_rows) - 1; $x >= 0; $x--) {
                echo $log_rows[$x];
            }
            
            fclose($handle);
        } else {
            echo "unable to open ALARMLOG.txt";
        }
    }
    
    
    
?>

</div>

</div>

</div>
