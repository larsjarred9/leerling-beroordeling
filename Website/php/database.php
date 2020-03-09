<?php
    $user = 'leerling';
    $pass = 'ol99$R7q';
    $db = '84644_leerlingsysteem';
    $host = '127.0.0.1:3306';

    $conn = new mysqli($host, $user, $pass, $db, 3306) or die("Unable to connect");
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>