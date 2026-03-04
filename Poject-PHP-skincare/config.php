<?php
// config.php - Lidhja me bazën e të dhënave duke përdorur PDO

$host = 'localhost';
$dbname = 'skincare_store'; // emri i databazës që ke krijuar
$username = 'root';
$password = ''; // zakonisht bosh në XAMPP


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Nuk u lidh dot me databazën: " . $e->getMessage());
}
?>