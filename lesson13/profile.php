<?php
  session_start();

  include_once('config.php');

  if(empty($_SESSION['username']))
  {
    header('Location: login.php')
  }

  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE id=:id";
  $selectUser = $conn->prepare($sql);
  $selectUser->bindParam(':id', $id);
  $selectUser->execute();

  $user_data = $selectUser->fetch();
?>