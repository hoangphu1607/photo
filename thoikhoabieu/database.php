<?php
    $db_server = "localhost";
    $db_username = "root";
    $db_pass = "";
    $db_name = "tiemphoto";
    $conn = "";

    $conn = new mysqli($db_server, $db_username, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo $conn->connect_error;
    }  else{
        
    }
?>