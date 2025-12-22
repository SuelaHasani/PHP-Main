<?php
try{
    $pdo = new PDO("mysql:host=localhost;dbname=db", "root", "");

    $username = "Suela";

    $password = password_hash("mypassword", PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    $pdo->exec($sql);

    echo "created successfully";
}catch (Exeption $e){
      echo $e->getMessage();
    }

?>