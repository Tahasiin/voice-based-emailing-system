<?php

$server   = 'localhost';
$username = 'root';
$password = '';
$database = 'voice_based_emailing';

$conn = new mysqli($server,$username,$password,$database);

if($conn->connect_error){
    die("Connection Failed:".$conn->connect_error);
}


