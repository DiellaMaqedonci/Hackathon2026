<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include_once('config.php');

if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: list_clothes.php"); exit; }

$user_id  = (int)$_SESSION['id'];
$cloth_id = (int)($_SESSION['cloth_id'] ?? 0);
$nr   = (int)($_POST['nr_donations'] ?? 0);
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';

if ($cloth_id <= 0) {
	die("No cloth selected. Open a cloth from the list first. <a href='list_clothes.php'>Go back</a>");
}
if ($nr < 1 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < date('Y-m-d') || $time === '') {
	die("Invalid pledge: choose a number, a date from today on, and a time. <a href='details.php?id=$cloth_id'>Go back</a>");
}

try {
	$st = $conn->prepare("INSERT INTO donations(user_id, cloth_id, nr_donations, date, time) VALUES (:u, :c, :n, :d, :t)");
	$st->execute([':u' => $user_id, ':c' => $cloth_id, ':n' => $nr, ':d' => $date, ':t' => $time]);
} catch (PDOException $e) {
	die("Could not save the pledge: " . htmlspecialchars($e->getMessage()) . " <a href='list_clothes.php'>Go back</a>");
}

header("Location: donations.php");
exit;