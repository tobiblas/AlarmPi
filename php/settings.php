
<script>
function setProperty(property, value)
{
    /*var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status != 200) {
                alert("Failed to set setting");
            }
            //alert (xmlHttp.responseText);
            window.location.href = window.location.href;
        }
    }
    xmlHttp.open("POST", "setting.php?" property + "=" + value, true); // true for asynchronous
    xmlHttp.send(null);*/
    alert (property + "=" + value);
    window.location.href = window.location.href;
}

</script>


<div class="row">
<div class="col-12">

<div id="settings">

    <div id="setting">
        <input id="soundcheckbox" type="checkbox" onchange="setProperty('sound', '' + document.getElementById('soundcheckbox').checked)"> Sound when alarm triggers<br>
    </div>

    <div id="setting">
        <input id="smscheckbox" type="checkbox" onchange="setProperty('sms', '' + document.getElementById('smscheckbox').checked)"> Send sms when alarm triggers<br>
    </div>

    <div id="setting">
        Phonenumbers to sms when alarm triggers (separate with ';') <input type="text" id="phonenumbertext"
onkeydown="if (event.keyCode == 13) setProperty('phoneNumbers', '' + document.getElementById('phonenumbertext').value)" ><br>
    </div>

    <div id="setting">
    <input id="mailcheckbox" type="checkbox" onchange="setProperty('mail', '' + document.getElementById('mailcheckbox').checked)"> Send mail when alarm triggers<br>
    </div>

    <div id="setting">
Mail addresses to email when alarm triggers (separate with ';') <input type="text" id="emailstext"
onkeydown="if (event.keyCode == 13) setProperty('emails', '' + document.getElementById('emailstext').value)" ><br>
    </div>

    <div id="setting">
    <input id="logwhenoffcheckbox" type="checkbox" onchange="setProperty('logwhenoff', '' + document.getElementById('logwhenoffcheckbox').checked)"> Log also when alarm is off<br>
    </div>

</div>

</div>

</div>

