<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
$adm = !empty($_SESSION['is_admin']); $my_ch = (int)($_SESSION['charity_id'] ?? 0);
if (!$adm && $my_ch < 1) { header("Location: dashboard.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
$st = $conn->prepare("SELECT charity_id FROM clothes WHERE id = :id"); $st->execute([':id' => $id]);
$row = $st->fetch();
if (!$row || (!$adm && (int)$row['charity_id'] !== $my_ch)) { header("Location: list_clothes.php"); exit; }
try {
	$conn->prepare("DELETE FROM donations WHERE cloth_id = :id")->execute([':id' => $id]);
	$conn->prepare("DELETE FROM clothes WHERE id = :id")->execute([':id' => $id]);
} catch (PDOException $e) {
	error_log($e->getMessage());
	die("Delete failed. <a href='list_clothes.php'>Go back</a>");
}
header("Location: list_clothes.php"); exit;