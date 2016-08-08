
<script>

function takePicture(IP) {
    
    var request = new XMLHttpRequest();
    var requestStr = "http.php?url=" + IP + "/alarm/take_picture.php";
    request.open('GET', requestStr, true);
    
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            // Success!
            var resp =request.responseText;
            alert ("Response: " + resp);
            //var theElement = document.getElementById(idOfElement);
            
            //theElement.innerHTML = resp;
        } else {
            // We reached our target server, but it returned an error
            alert ("error for IP " + IP + ": " + request.responseText);
            //var theElement = document.getElementById(idOfTempElement);
            //theElement.innerHTML = "Error";
        }
    };
    
    request.onerror = function() {
        alert("There was a connection error of some sort for " + IP);
        alert ("error for IP " + IP + ": " + request.responseText);
        //var theElement = document.getElementById(idOfTempElement);
        //theElement.innerHTML = "Error";
    };
    
    request.send();
    
}
</script>


<?php
    include("config.php");

    
if ($config['deviceIPs'] != null && $config['devices'] != null && trim($config['devices']) != '' && trim($config['deviceIPs']) != '') {
    
    $IPs = explode(',', $config['deviceIPs']);
    $devices = explode(',', $config['devices']);
    foreach($IPs as $index => $IP) {
        $IP = trim($IP);
        echo '<div class="row">' . PHP_EOL;
        echo '<div class="col-6">' . PHP_EOL;
        echo '<div class="devicelocation">' . PHP_EOL;
        echo $devices[$index] . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '<div class="col-6">' . PHP_EOL;
        echo '<div class="captureimage">' . PHP_EOL;
        echo '<button onclick="takePicture(\'' . $IP . '\')" >CAPTURE!</button>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    }
    echo '<hr>';
    
    foreach($IPs as $index => $IP) {
        $IP = trim($IP);
        echo '<div class="row">' . PHP_EOL;
        echo '<div class="col-12">' . PHP_EOL;
        echo '<div class="devicdeheaderimages">' . $devices[$index] . '</div>' . PHP_EOL;
        echo '<div class="deviceimages" id="'.$devices[$index].'">' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        #echo '<script>fetchImagesFromDevice("'. $IP .'", "' .$devices[$index] . '");</script>' . PHP_EOL;
    }
    
} else {
    echo "No configured devices";
}
?>

<!--
<div class="row">
<div class="col-6">
<img class="alarmimage" src="https://www.nasa.gov/sites/default/files/styles/image_card_4x3_ratio/public/thumbnails/image/nh-scatteringmapcontext_06_29_16-v3-small4review.jpg?itok=fw6PtiG7" />
</div>
<div class="col-6">
<img src="http://www.daily-sun.com/assets/archive/images/online/2016/July/07-07-2016/Daily-sun_Hitomi%20satellite%20image3_picture.jpg"  class="alarmimage" />
</div>
</div>
-->
