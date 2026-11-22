<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
$adm = !empty($_SESSION['is_admin']); $mine = (int)($_SESSION['charity_id'] ?? 0);
if (!$adm && !$mine) { header("Location: dashboard.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
	if ($adm) {
		$st = $conn->prepare("UPDATE `donations` SET `is_approved` = 'false' WHERE id=:id");
		$st->bindParam(':id', $id, PDO::PARAM_INT);
	} else {
		// a charity account may only decline pledges made to its own needs
		$st = $conn->prepare("UPDATE `donations` d INNER JOIN `clothes` c ON c.id = d.cloth_id SET d.`is_approved` = 'false' WHERE d.id=:id AND c.charity_id=:m");
		$st->bindParam(':id', $id, PDO::PARAM_INT);
		$st->bindParam(':m', $mine, PDO::PARAM_INT);
	}
	$st->execute();
}
header("Location: donations.php"); exit;