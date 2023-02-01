<?php 
$hostname = "localhost";
$databaseName = "emblicdb";
$userName = "root";
$password = "";
 
$connect = mysqli_connect($hostname, $userName, $password, $databaseName);
if(!$connect){
    echo "connection failed";
}

?>