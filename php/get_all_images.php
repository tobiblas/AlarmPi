<?php
    
    $config = array();
    
    $dir    = '/var/www/html/alarm/photos';
    #$dir    = 'photos';
    $files1 = scandir($dir);
    #$files2 = scandir($dir, 1);
    
    #print_r($files1);

    foreach ($files1 as $value) {
        if (strlen($value) > 4) {
            echo $value . PHP_EOL;
        }
    }
?>