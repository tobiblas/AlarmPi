
<script>
function setProperty(property, value)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status != 200) {
                alert("Failed to set setting");
            }
            //alert (xmlHttp.responseText);
            window.location.href = window.location.href;
        }
    }
    xmlHttp.open("GET", "change_setting.php?key=" + property + "&value=" + encodeURIComponent(value), true); // true for asynchronous
    xmlHttp.setRequestHeader("Authorization", "Basic dG9iaWFzOnRvYmJlag==")
    xmlHttp.send(null);
}

function saveCron() {

    var cron = document.getElementById("crontabText").value;

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status != 200) {
                alert("Failed to add to cron");
            }
            //alert (xmlHttp.responseText);
            //window.location.href = window.location.href;
        }
    }
    xmlHttp.open("GET", "add_to_cron.php?value=" + encodeURIComponent(cron), true); // true for asynchronous
    xmlHttp.setRequestHeader("Authorization", "Basic dG9iaWFzOnRvYmJlag==")
    xmlHttp.send(null);
}

</script>

<?php
include("config.php");
?>


<div class="row">
<div class="col-12">

<div id="settings">

<div id="setting">
List of connected device IDs with camera (Example: livingroom,kitchen,garage). Use comma as separator and no funny characters or spaces.<br/><input type="text" id="devicesText" value=<?php if ($config['devices'] != NULL) { echo '"' . $config['devices'] . '"';} else { echo '""';} ?>
onkeydown="if (event.keyCode == 13) setProperty('devices', '' + document.getElementById('devicesText').value)" ><br>
</div>

<div id="setting">
List of connected device IP addresses (same order as above) (Example: 192.168.0.100,192.168.0.104,192.168.0.105). Use comma as separator and no funny characters or spaces. Make sure the IP addresses are static (configure this in your router settings) <br/><input type="text" id="deviceIPsText" value=<?php if ($config['deviceIPs'] != NULL) { echo '"' . $config['deviceIPs'] . '"';} else { echo '""';} ?>
onkeydown="if (event.keyCode == 13) setProperty('deviceIPs', '' + document.getElementById('deviceIPsText').value)" ><br>
</div>

    <div id="setting">
    <input id="mailcheckbox" <?php if ($config['mail'] == 'true' || $config['mail'] == NULL) { echo "checked";} ?> type="checkbox" onchange="setProperty('mail', '' + document.getElementById('mailcheckbox').checked)"> Send mail when alarm triggers<br>
    </div>

    <div id="setting">
Mail addresses to email when alarm triggers (separate with ';') <br/><input type="text" id="emailstext" value=<?php if ($config['emails'] != NULL) { echo '"' . $config['emails'] . '"';} else { echo '""';} ?>
onkeydown="if (event.keyCode == 13) setProperty('emails', '' + document.getElementById('emailstext').value)" ><br>
    </div>

    <div id="setting">
    <input id="logwhenoffcheckbox" <?php if ($config['logwhenoff'] == 'true' || $config['logwhenoff'] == NULL) { echo "checked";} ?> type="checkbox" onchange="setProperty('logwhenoff', '' + document.getElementById('logwhenoffcheckbox').checked)"> Log also when alarm is off<br>
    </div>

    <div id="setting">
    <input id="sound" <?php if ($config['sound'] == 'true' || $config['sound'] == NULL) { echo "checked";} ?> type="checkbox" onchange="setProperty('sound', '' + document.getElementById('sound').checked)"> Make sound on detection when alarm is on.<br>
    </div>

    <div id="setting">
External IP to alarm central (Example: 74.99.99.99) <br/><input type="text" id="externalIPText" value=<?php if ($config['externalIP'] != NULL) { echo '"' . $config['externalIP'] . '"';} else { echo '""';} ?>
    onkeydown="if (event.keyCode == 13) setProperty('externalIP', '' + document.getElementById('externalIPText').value)" ><br>
    </div>

    <div id="setting">
Current crontab (updates every minute). Example: turn on alarm monday 02:00: 0 2 * * 1 ON<br/>
    <div class="code" id="croncode">

<textarea id="crontabText" rows="10" cols="50">
<?php
    include("getCron.php");
    ?>
</textarea>
</div>
<br>
<button onclick="saveCron()">Save crontab</button>
    </div>
</div>

</div>

</div>
