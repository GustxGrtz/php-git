<?php 

    $host = "localhost"; 
    $user = "root";
    $pass = "";
    $dbname = "projetest";
    // $port =  127.0; 

    $conn = new PDO("mysql:host=$host;dbname=".$dbname,$user,$pass);
?>