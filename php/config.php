<?php
    $myfile = fopen("admin.properties", "r") or die("Unable to open file!");
    $fileline = fgets($myfile);
    fclose($myfile);
    $alarm_path = trim(substr($fileline, strpos($fileline, ":") + 1));
?>