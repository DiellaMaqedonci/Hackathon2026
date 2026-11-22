<?php
session_start();
include_once('config.php');
if (empty($_SESSION['username'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['is_admin'])) { header("Location: dashboard.php"); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: dashboard.php"); exit; }

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? ''); $username = trim($_POST['username'] ?? ''); $email = trim($_POST['email'] ?? '');
$cid = (int)($_POST['charity_id'] ?? 0); $cid = $cid > 0 ? $cid : null;

if ($id <= 0 || $name === '' || $username === '' || $email === '') { die("You have not filled in all the fields. <a href='editUsers.php?id=$id'>Go back</a>"); }
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { die("Please enter a valid email address. <a href='editUsers.php?id=$id'>Go back</a>"); }
try {
	$st = $conn->prepare("UPDATE users SET name=:n, username=:u, email=:e, charity_id=:c WHERE id=:id");
	$st->execute([':n'=>$name, ':u'=>$username, ':e'=>$email, ':c'=>$cid, ':id'=>$id]);
} catch (PDOException $e) {
	if ($e->getCode() == 23000) { die("Username or email is already in use. <a href='editUsers.php?id=$id'>Go back</a>"); }
	error_log($e->getMessage());
	die("Update failed. Please try again.");
}
header("Location: dashboard.php"); exit;