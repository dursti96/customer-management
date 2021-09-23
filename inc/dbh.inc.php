<?php

// file to connect to database

$serverName="localhost";
$dBUserName="alex";
$dBPassword="asdf";
$dBName="kompetenzphp";


$conn = mysqli_connect($serverName,$dBUserName,$dBPassword,$dBName);


//check if connection works; if not, print error
if(!$conn) {
    die("Connection failed" . mysqli_connect_error());
}







