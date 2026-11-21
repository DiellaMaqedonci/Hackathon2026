<?php	

//Including config.php file for connection with database 
	include_once('config.php');

//If the button Add Clothes in clothes.php is pressed, we will get datas that users added into the form, and insert them into database :
	if(isset($_POST['submit']))
	{

		$cloth_name = $_POST['cloth_name'];
		$cloth_desc = $_POST['cloth_desc'];
		$cloth_quality = $_POST['cloth_quantity'];
		$cloth_rating = $_POST['cloth_size'];
		$cloth_image = $_POST['cloth_img'];
	

		$sql = "INSERT INTO clothes(cloth_name, cloth_desc, cloth_quantity, cloth_size, cloth_img) VALUES (:cloth_name, :cloth_desc, :cloth_quantity, :cloth_size, :cloth_img)";

		$insertMovie = $conn->prepare($sql);
			

		$insertMovie->bindParam(':cloth_name', $cloth_name);
		$insertMovie->bindParam(':cloth_desc', $cloth_desc);
		$insertMovie->bindParam(':cloth_quantity', $cloth_quantity);
		$insertMovie->bindParam(':cloth_size', $cloth_size);
		$insertMovie->bindParam(':cloth_img', $cloth_img);

		$insertMovie->execute();

		header("Location: clothes.php");


	}




?>