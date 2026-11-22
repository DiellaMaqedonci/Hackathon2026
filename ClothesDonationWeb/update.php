<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
$adm = !empty($_SESSION['is_admin']); $my_ch = (int)($_SESSION['charity_id'] ?? 0);
if (!$adm && $my_ch < 1) { header("Location: dashboard.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: list_clothes.php"); exit; }

$id   = (int)($_POST['id'] ?? 0);
$name = trim($_POST['cloth_name'] ?? '');
$desc = trim($_POST['cloth_desc'] ?? '');
$qty  = (int)($_POST['cloth_quantity'] ?? 0);
$size = $_POST['cloth_size'] ?? '';
$img  = trim($_POST['cloth_img'] ?? '');

$st = $conn->prepare("SELECT charity_id FROM clothes WHERE id = :id"); $st->execute([':id' => $id]);
$row = $st->fetch();
if (!$row || (!$adm && (int)$row['charity_id'] !== $my_ch)) { header("Location: list_clothes.php"); exit; }
$cid = $adm ? (int)($_POST['charity_id'] ?? 0) : $my_ch;

if ($id <= 0 || $name === '' || $desc === '' || $qty < 1 || $cid < 1 || !is_numeric($size)) {
	die("Please fill in every field and choose a charity (size must be a number). <a href='list_clothes.php'>Go back</a>");
}
try {
	$st = $conn->prepare("UPDATE clothes SET cloth_name=:n, cloth_desc=:d, cloth_quantity=:q, cloth_size=:s, cloth_img=:i, charity_id=:c WHERE id=:id");
	$st->execute([':n'=>$name, ':d'=>$desc, ':q'=>$qty, ':s'=>$size, ':i'=>$img, ':c'=>$cid, ':id'=>$id]);
} catch (PDOException $e) {
	die("Could not save: " . htmlspecialchars($e->getMessage()) . " <a href='list_clothes.php'>Go back</a>");
}
header("Location: list_clothes.php?charity=" . $cid); exit;