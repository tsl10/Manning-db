<?php
$host="localhost";
$user="kamilmwg_test";
$pass="Test@db24";
$db="kamilmwg_cv_management";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}
?> 
