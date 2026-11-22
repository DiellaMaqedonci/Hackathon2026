<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['is_admin'])) { header("Location: dashboard.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) { $st = $conn->prepare("UPDATE `donations` SET `is_approved` = 'true' WHERE id=:id"); $st->bindParam(':id', $id, PDO::PARAM_INT); $st->execute(); }
header("Location: donations.php"); exit;