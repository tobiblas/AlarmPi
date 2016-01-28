<html>
<head>
<title>Home admin</title>
<link rel="stylesheet" href="styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script>
function toggle_alarm()
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status != 200) {
                alert("FAILED TO TOGGLE ALARM!");
            }
            //alert (xmlHttp.responseText);
            window.location.href = window.location.href;
        }
    }
    xmlHttp.open("GET", "toggle_alarm.php", true); // true for asynchronous
    xmlHttp.send(null);
}

function menuselected(itemselected) {
    var url = window.location.href;
    if (url.indexOf('?') > -1){
        url = url.substr(0, url.indexOf('?'));
    }
    url += '?menuitem=' + itemselected;
    
    window.location.href = url;
}

</script>


</head>
<body>


<div class="header">
<h1>Alarm admin</h1>
</div>

<div class="row">

<?php
    $menuselected = 0;
    $menuitem = $_GET['menuitem'];
    if ($menuitem == 1) {
        $menuselected = 1;
    } else if ($menuitem == 2) {
        $menuselected = 2;
    } else if ($menuitem == 3) {
        $menuselected = 3;
    }
?>

<div class="col-3 menu">
    <input type="checkbox" <?php echo ($menuselected == 0 ? "checked " : "");?> onclick="menuselected(0)" class="menucheckbox" id="menucheckbox1">
<label class="menulabel" for="menucheckbox1" <?php echo ($menuselected == 0 ? "style='background-color :#6EA53B;'" : "") ?> >Status</label>
</div>
<div class="col-3 menu">
    <input type="checkbox" <?php echo ($menuselected == 1 ? "checked " : "");?> onclick="menuselected(1)" class="menucheckbox" id="menucheckbox2">
    <label class="menulabel" for="menucheckbox2" <?php echo ($menuselected == 1 ? "style='background-color :#6EA53B;'" : "") ?> >Log</label>
</div>
<div class="col-3 menu">
    <input type="checkbox" <?php echo ($menuselected == 2 ? "checked " : "");?> onclick="menuselected(2)" class="menucheckbox" id="menucheckbox3">
    <label class="menulabel" for="menucheckbox3" <?php echo ($menuselected == 2 ? "style='background-color :#6EA53B;'" : "") ?> >Camera</label>
</div>
<div class="col-3 menu">
<input type="checkbox" <?php echo ($menuselected == 3 ? "checked " : "");?> onclick="menuselected(3)" class="menucheckbox" id="menucheckbox4">
<label class="menulabel" for="menucheckbox4" <?php echo ($menuselected == 3 ? "style='background-color :#6EA53B;'" : "") ?> >Settings</label>
</div>


</div>


<?php
    if ($menuselected == 0) {
        include("status.php");
    } else if ($menuselected == 1) {
        $alarm_on_filter = 'true';
        $alarm_off_filter = 'true';
        include("logs.php");
    } else if ($menuselected == 2) {
        include("camera.php");
    } else if ($menuselected == 3) {
        include("settings.php");
    }
?>

</body>
</html>
