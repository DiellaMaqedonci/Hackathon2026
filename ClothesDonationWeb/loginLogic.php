<?php
session_start();
include_once('config.php');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: login.php'); exit; }

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($username === '' || $password === '') {
	$_SESSION['login_error'] = "Please fill in all fields.";
	header('Location: login.php'); exit;
}

$selectUser = $conn->prepare("SELECT id, name, username, email, password, is_admin, charity_id FROM users WHERE username=:username");
$selectUser->bindParam(":username", $username);
$selectUser->execute();
$data = $selectUser->fetch(PDO::FETCH_ASSOC);

if ($data && password_verify($password, $data['password'])) {
	session_regenerate_id(true);
	$_SESSION['id'] = $data['id'];
	$_SESSION['username'] = $data['username'];
	$_SESSION['email'] = $data['email'];
	$_SESSION['name'] = $data['name'];
	$_SESSION['is_admin'] = ($data['is_admin'] === 'true' || $data['is_admin'] == 1);
	$_SESSION['charity_id'] = (int)($data['charity_id'] ?? 0);
	header('Location: dashboard.php'); exit;
}
$_SESSION['login_error'] = "Invalid username or password.";
header('Location: login.php'); exit;