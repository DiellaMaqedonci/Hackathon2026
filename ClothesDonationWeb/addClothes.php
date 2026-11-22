<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
$adm = !empty($_SESSION['is_admin']); $my_ch = (int)($_SESSION['charity_id'] ?? 0);
if (!$adm && $my_ch < 1) { header("Location: dashboard.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: clothes.php"); exit; }

$name = trim($_POST['cloth_name'] ?? '');
$desc = trim($_POST['cloth_desc'] ?? '');
$qty  = (int)($_POST['cloth_quantity'] ?? 0);
$size = $_POST['cloth_size'] ?? '';
$img  = trim($_POST['cloth_img'] ?? '');
$cid  = $adm ? (int)($_POST['charity_id'] ?? 0) : $my_ch;   // a charity can only post for itself

if ($name === '' || $desc === '' || $qty < 1 || $cid < 1 || !is_numeric($size)) {
	die("Please fill in every field and choose a charity (size must be a number). <a href='clothes.php'>Go back</a>");
}
try {
	$st = $conn->prepare("INSERT INTO clothes(cloth_name, cloth_desc, cloth_quantity, cloth_size, cloth_img, charity_id) VALUES (:n, :d, :q, :s, :i, :c)");
	$st->execute([':n'=>$name, ':d'=>$desc, ':q'=>$qty, ':s'=>$size, ':i'=>$img, ':c'=>$cid]);
} catch (PDOException $e) {
	die("Could not save: " . htmlspecialchars($e->getMessage()) . " <a href='clothes.php'>Go back</a>");
}
header("Location: list_clothes.php?charity=" . $cid); exit;