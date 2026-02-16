<?php	

	include_once('db.php');

	if(isset($_POST['submit']))
	{

		$book_name = $_POST['book_name'];
		$book_desc = $_POST['book_desc'];
		$book_quality = $_POST['book_quality'];
		$book_rating = $_POST['book_rating'];
		$book_image = $_POST['book_image'];
	

		$sql = "INSERT INTO movies(book_name, book_desc, book_quality, book_rating, book_image) VALUES (:book_name, :book_desc, :book_quality, :book_rating, :book_image)";

		$insertMovie = $conn->prepare($sql);
			

		$insertMovie->bindParam(':book_name', $book_name);
		$insertMovie->bindParam(':book_desc', $book_desc);
		$insertMovie->bindParam(':book_quality', $book_quality);
		$insertMovie->bindParam(':book_rating', $book_rating);
		$insertMovie->bindParam(':book_image', $book_image);

		$insertMovie->execute();

		header("Location: movies.php");


	}
?>