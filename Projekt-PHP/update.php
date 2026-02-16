<?php
 
 include_once('db.php');

 if(isset($_POST['submit'])) {
    $id = $_POST['id'];
	$book_name = $_POST['book_name'];
	$book_desc = $_POST['book_desc'];
	$book_quality = $_POST['book_quality'];
	$book_rating=$_POST['book_rating'];

    $sql = "UPDATE books SET id=:id,  book_name=:book_name, book_desc=:book_desc, book_quality=:book_quality,book_rating=:book_rating WHERE id=:id";

    $prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id);
		$prep->bindParam(':book_name',$book_name);
		$prep->bindParam(':book_desc',$book_desc);
		$prep->bindParam(':book_quality',$book_quality);
		$prep->bindParam(':book_rating',$book_rating);
		
		$prep->execute();
		header("Location: dashboard.php");
 }

?>