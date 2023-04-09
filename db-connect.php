<?php

$server = 'localhost';
$database = 'login';
$user = 'root';
$password = '';

$con = new mysqli($server, $user, $password, $database);

if($con->connect_error){
    die("Connection Failed: " . $con->connect_error);
}else{
    // echo "Connected";
}

?>