<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
$adm = !empty($_SESSION['is_admin']); $my_ch = (int)($_SESSION['charity_id'] ?? 0);
if (!$adm && $my_ch < 1) { header("Location: dashboard.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
// a charity can only confirm pledges made to its own needs
$st = $conn->prepare("SELECT clothes.charity_id FROM donations INNER JOIN clothes ON clothes.id = donations.cloth_id WHERE donations.id = :id");
$st->execute([':id' => $id]);
$row = $st->fetch();
if ($row && ($adm || (int)$row['charity_id'] === $my_ch)) {
	$conn->prepare("UPDATE donations SET is_approved = 'false' WHERE id = :id")->execute([':id' => $id]);
}
header("Location: donations.php"); exit;