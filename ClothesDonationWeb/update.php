<!<?php 
/*
We will get the changed data from edit.php file and update them into database
*/
	session_start();

	include_once('config.php');

	//Only logged in admins can update movies
	if (empty($_SESSION['username'])) {
		header("Location: login.php");
		exit;
	}
	if (empty($_SESSION['is_admin'])) {
		header("Location: dashboard.php");
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id = (int)($_POST['id'] ?? 0);
		$cloth_name = trim($_POST['cloth_name'] ?? '');
		$cloth_desc = trim($_POST['cloth_desc'] ?? '');
		$cloth_quantity = trim($_POST['cloth_quantity'] ?? '');
		$cloth_size = $_POST['cloth_size'] ?? '';

		if ($id <= 0 || $cloth_name === '' || $cloth_desc === '' || $cloth_quantity === '' || !is_numeric($cloth_size)) {
			die("Invalid data. Please go back and fill in all fields correctly.");
		}

		//The id is only used in WHERE; changing a primary key in SET makes no sense
		$sql = "UPDATE clothes SET cloth_name=:cloth_name, cloth_desc=:cloth_desc, cloth_quantity=:cloth_quantity, cloth_size=:cloth_size WHERE id=:id";

		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id, PDO::PARAM_INT);
		$prep->bindParam(':cloth_name',$movie_name);
		$prep->bindParam(':cloth_desc',$movie_desc);
		$prep->bindParam(':cloth_quantity',$movie_quantity);
		$prep->bindParam(':cloth_size',$movie_size);

		$prep->execute();
	}

	header("Location: dashboard.php");
	exit; -->

<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['is_admin'])) { header("Location: dashboard.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = (int)($_POST['id'] ?? 0); $name = trim($_POST['cloth_name'] ?? ''); $desc = trim($_POST['cloth_desc'] ?? '');
	$qty = (int)($_POST['cloth_quantity'] ?? 0); $size = $_POST['cloth_size'] ?? '';
	if ($id <= 0 || $name === '' || $desc === '' || $qty < 1 || !is_numeric($size)) { die("Invalid data. Please go back and fill in all fields correctly."); }
	$st = $conn->prepare("UPDATE clothes SET cloth_name=:n, cloth_desc=:d, cloth_quantity=:q, cloth_size=:s WHERE id=:id");
	$st->execute([':n'=>$name, ':d'=>$desc, ':q'=>$qty, ':s'=>$size, ':id'=>$id]);
}
header("Location: list_clothes.php"); exit;