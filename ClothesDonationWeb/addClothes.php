<!-- <?php	

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




?> -->


<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['is_admin'])) { header("Location: dashboard.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$name = trim($_POST['cloth_name'] ?? ''); $desc = trim($_POST['cloth_desc'] ?? '');
	$qty = (int)($_POST['cloth_quantity'] ?? 0); $size = $_POST['cloth_size'] ?? ''; $img = trim($_POST['cloth_img'] ?? '');
	if ($name === '' || $desc === '' || $qty < 1 || !is_numeric($size)) { die("Invalid data. <a href='clothes.php'>Go back</a>"); }
	$st = $conn->prepare("INSERT INTO clothes(cloth_name, cloth_desc, cloth_quantity, cloth_size, cloth_img) VALUES (:n, :d, :q, :s, :i)");
	$st->execute([':n'=>$name, ':d'=>$desc, ':q'=>$qty, ':s'=>$size, ':i'=>$img]);
}
header("Location: list_clothes.php"); exit;