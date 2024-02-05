<?php

$host = 'localhost';
$port = '3307';
$database =  'crud';
$username =  'root';
$password =  '0317';


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
