
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
    xmlHttp.send(null);
}

function newCronRow() {
    var cron = prompt("Enter new row to be added to cron", "");
    
    if (cron != null) {
        document.getElementById("croncode").innerHTML = document.getElementById("croncode").innerHTML + cron + "<br/>";
    }
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
<input id="soundcheckbox" <?php if ($config['sound'] == 'true' || $config['sound'] == NULL) { echo "checked";} ?> type="checkbox" onchange="setProperty('sound', '' + document.getElementById('soundcheckbox').checked)"> Sound when alarm triggers<br>
    </div>

    <div id="setting">
        <input id="smscheckbox" <?php if ($config['sms'] == 'true' || $config['sms'] == NULL) { echo "checked";} ?> type="checkbox" onchange="setProperty('sms', '' + document.getElementById('smscheckbox').checked)"> Send sms when alarm triggers<br>
    </div>

    <div id="setting">
Phonenumbers to sms when alarm triggers. Separate numbers with ';'. Example: +46760999999 <br/><input type="text" id="phonenumbertext" value=<?php if ($config['phoneNumbers'] != NULL) { echo '"' . $config['phoneNumbers'] . '"';} else { echo '""';} ?>
onkeydown="if (event.keyCode == 13) setProperty('phoneNumbers', '' + document.getElementById('phonenumbertext').value)" ><br>
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
External IP to alarm central (Example: 74.99.99.99) <br/><input type="text" id="externalIPText" value=<?php if ($config['externalIP'] != NULL) { echo '"' . $config['externalIP'] . '"';} else { echo '""';} ?>
    onkeydown="if (event.keyCode == 13) setProperty('externalIP', '' + document.getElementById('externalIPText').value)" ><br>
    </div>

    <div id="setting">
Current crontab (updates every minute): <br/>
    <div class="code" id="croncode">

<textarea rows="10" cols="50">
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


