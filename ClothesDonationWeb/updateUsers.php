<?php 
/*
We will get the changed data from editUsers.php file and update them into database
*/
	session_start();

	include_once('config.php');

	//Only logged in admins can update users
	if (empty($_SESSION['username'])) {
		header("Location: login.php");
		exit;
	}
	if (empty($_SESSION['is_admin'])) {
		header("Location: dashboard.php");
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id = (int)($_POST['id'] ?? 0);
		$name = trim($_POST['name'] ?? '');
		$username = trim($_POST['username'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$cid = (int)($_POST['charity_id'] ?? 0);

		if ($id <= 0 || $name === '' || $username === '' || $email === '') {
			die("You have not filled in all the fields. <a href='editUsers.php?id=" . $id . "'>Go back</a>");
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			die("Please enter a valid email address. <a href='editUsers.php?id=" . $id . "'>Go back</a>");
		}

		//The id is only used in WHERE; changing a primary key in SET makes no sense
		$sql = "UPDATE users SET name=:name, username=:username, email=:email, charity_id=:cid WHERE id=:id";

		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id, PDO::PARAM_INT);
		$prep->bindParam(':name',$name);
		$prep->bindParam(':username',$username);
		$prep->bindParam(':email',$email);
		$prep->bindValue(':cid', $cid > 0 ? $cid : null, $cid > 0 ? PDO::PARAM_INT : PDO::PARAM_NULL);

		try {
			$prep->execute();
		} catch (PDOException $e) {
			//23000 = duplicate key: another user already has this username or email
			if ($e->getCode() == 23000) {
				die("Username or email is already in use, or the charity does not exist. <a href='editUsers.php?id=" . $id . "'>Go back</a>");
			}
			error_log($e->getMessage());
			die("Update failed. Please try again.");
		}
	}

	header("Location: dashboard.php");
	exit;