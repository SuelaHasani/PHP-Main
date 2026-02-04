<?php 

	include_once('config.php');

	if(isset($_POST['update']))
	{
		$id=$_POST['id'];
		$title = $_POST['title'];
		$decription = $_POST['decription'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		$tempPass = $_POST['password'];
		$password = password_hash($tempPass, PASSWORD_DEFAULT);

		if(empty($title) || empty($decription) || empty($quantity) || empty($price) || empty($password))
		{
			echo "You need to fill all the fields.";
			header( "refresh:2; url=profile.php" ); 
		}
		else
		{
			$sql= "UPDATE users SET name=:name, surname=:surname, username=:username, email=:email, password=:password WHERE id=:id";

			$updateSql = $conn->prepare($sql);

			$updateSql->bindParam(':id', $id);
			$updateSql->bindParam(':title', $title);
			$updateSql->bindParam(':decription', $decripttion);
			$updateSql->bindParam(':quantity', $quantity);
			$updateSql->bindParam(':price', $price);
			$updateSql->bindParam(':password', $password);

			$updateSql->execute();

			header('Location: logout.php');
		}
	}
?>