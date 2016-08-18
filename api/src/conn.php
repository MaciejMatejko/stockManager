<?php


$DBusername = "root";
$DBpassword = "coderslab";
$DBadress = "localhost";
$DBname = "stockManager";

$conn = new mysqli($DBadress, $DBusername, $DBpassword, $DBname);

if($conn->error){
    die("Cant connect to database. Error: ".$conn->error);
}

