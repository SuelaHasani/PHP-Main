<?php
session_start();

$user="root";
$pass="";
$server="localhost";
$dbname="db";

try {
	
	$conn =new PDO("mysql:host=$server;dbname=$dbname",$user,$pass);

} catch (PDOException $e) {
	echo "error: " . $e->getMessage();
}

 ?>


<!-- id titulli autori viti sasia  per Biblioteka  
hp.2LIdhja me dtbaz(db.php)  
hp.3Shtimi librit(create.php)
 hp4Shfaqja(index.php) librave
  hp5delete 
  hp6.update -->