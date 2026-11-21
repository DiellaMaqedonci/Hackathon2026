<!-- <?php 
	/* 
	 We will include config.php for connection with database.
	 We will get the donations id and update the database based on that donations id
	*/
	include_once('config.php');

	$id = $_GET['id'];
	$sql = "UPDATE `donations` SET `is_approved` = 'true' WHERE id=:id";
	$prep = $conn->prepare($sql);
	$prep->bindParam(':id',$id);
	$prep->execute();

	header("Location: list_clothes.php");
 ?>
 

 -->


 <?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['is_admin'])) { header("Location: dashboard.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) { $st = $conn->prepare("UPDATE `donations` SET `is_approved` = 'true' WHERE id=:id"); $st->bindParam(':id', $id, PDO::PARAM_INT); $st->execute(); }
header("Location: donations.php"); exit;