<?php
    include("config.php");
    
    $key_sent = $_GET['key'];
    $value_sent = $_GET['value'];
	
    echo $key_sent;
    echo $value_sent;

    // string to put username and passwords
    $new_file_data = '';
    $key_found = False;
    
    foreach ($config as $key => $value) {
        if ($key == trim($key_sent)) {
            $new_file_data = $new_file_data . $key_sent . ':' . $value_sent . "\n";
            $key_found = True;
        } else {
            $new_file_data = $new_file_data . $key . ':' . $value . "\n";
        }
    }
    
    if (!$key_found) {
        $new_file_data = $new_file_data . $key_sent . ':' . $value_sent . "\n";
    }

    echo "writing " . $new_file_data;    
    file_put_contents('admin.properties', $new_file_data);
?>
