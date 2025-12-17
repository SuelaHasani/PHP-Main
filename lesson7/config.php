<?php

$host="localhost";
$user="root";
$pass="";
try{

    $conn=new PDO("mysql:host=$host",$user,$pass);
    $sql="Create database testdb";
    $conn->exec($sql);
    echo "Database created successfully";
    echo "Connected";

}catch(Exception $e){
    echo "Not Connected";
}

?>