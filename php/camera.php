
<script>

function takePicture(IP) {
    var request = new XMLHttpRequest();
    var requestStr = "http.php?url=" + IP + "/alarm/take_picture.php";
    request.open('GET', requestStr, true);
    
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            // Success!
            var resp =request.responseText;
            window.location.href = window.location.href;
        } else {
            // We reached our target server, but it returned an error
            alert ("error for IP " + IP + ": " + request.responseText);
        }
    };
    
    request.onerror = function() {
        alert("There was a connection error of some sort for " + IP);
        alert ("error for IP " + IP + ": " + request.responseText);
    };
    
    request.send();
    
}

function fetchImagesFromDevice(IP, elementIdToAddTo) {
    var request = new XMLHttpRequest();
    var requestStr = "http.php?url=" + IP + "/alarm/get_all_images.php";
    request.open('GET', requestStr, true);
    
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            // Success!
            var resp =request.responseText;
            
            var html = '';
            
            var element = document.getElementById(elementIdToAddTo);
            
            var res = resp.split("\n");
            for (var i = 0; i < res.length; ++i) {
                if (res[i].indexOf(".jpg") !== -1) {
                    //alert(res[i]);
                    if (i % 2 === 0) {
                        html += '<div class="row"><div class="col-6"><div class="alarmimagetitle">'+(res[i].trim())+'</div><img class="alarmimage" src="http://' + IP + '/photos/' + (res[i].trim()) + '" /></div>';
                    } else {
                        html += '<div class="col-6"><div class="alarmimagetitle">'+(res[i].trim())+'</div><img class="alarmimage" src="http://' + IP + '/photos/' + (res[i].trim()) + '" /></div></div>';
                    }
                }
            }
            
            if (res.length % 2 !== 0) {
                html += '</div>';
            }
            
            element.innerHTML = html;
            
        } else {
            // We reached our target server, but it returned an error
            alert ("error for IP " + IP + ": " + request.responseText);
        }
    };
    
    request.onerror = function() {
        alert("There was a connection error of some sort for " + IP);
        alert ("error for IP " + IP + ": " + request.responseText);
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
        echo '<script>fetchImagesFromDevice("'. $IP .'", "' .$devices[$index] . '");</script>' . PHP_EOL;
    }
    
} else {
    echo "No configured devices";
}
?>

<!--
<div class="row"><div class="col-6"><img class="alarmimage" src="" /></div>
<div class="col-6"><img class="alarmimage" src=""/></div></div>
-->
