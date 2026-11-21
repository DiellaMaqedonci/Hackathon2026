<!-- <?php 
 /*Creating a session  based on a session identifier, passed via a GET or POST request.
  We will include config.php for connection with database.
  */

	session_start();

	include_once('config.php');

	//Getting values 'id' and 'cloth_id' using $_SESSION
	$user_id = $_SESSION['id'];
    $cloth_id = $_SESSION['cloth_id'];

	//Getting some of data from details.php form
	$nr_donations = $_POST['nr_donations'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	//Inserting the new data into database
	$sql = "INSERT INTO donations(user_id, cloth_id, nr_donations, date, time) VALUES (:user_id, :cloth_id, :nr_donations, :date, :time)";

	$insertDonations = $conn->prepare($sql);

	$insertDonations->bindParam(":user_id", $user_id);
	$insertDonations->bindParam(":cloth_id", $cloth_id);
	$insertDonations->bindParam(":nr_donations", $nr_donations);
	$insertDonations->bindParam(":date", $date);
	$insertDonations->bindParam(":time", $time);

	$insertDonations->execute();

	header("Location: home.php");

	
	











 ?> -->


<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: list_clothes.php"); exit; }
$user_id = (int)$_SESSION['id']; $cloth_id = (int)($_SESSION['cloth_id'] ?? 0);
$nr = (int)($_POST['nr_donations'] ?? 0); $date = $_POST['date'] ?? ''; $time = $_POST['time'] ?? '';
if ($cloth_id <= 0 || $nr < 1 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < date('Y-m-d') || !preg_match('/^\d{2}:\d{2}$/', $time)) {
	die("Invalid pledge. <a href='list_clothes.php'>Go back</a>");
}
$st = $conn->prepare("INSERT INTO donations(user_id, cloth_id, nr_donations, date, time) VALUES (:u, :c, :n, :d, :t)");
$st->execute([':u'=>$user_id, ':c'=>$cloth_id, ':n'=>$nr, ':d'=>$date, ':t'=>$time]);
header("Location: donations.php"); 
exit;