<?php 
	/* 
	We will include config.php for connection with database.
	Delete a movie based on his id.
	*/
	session_start();

	include_once('config.php');

	//Only logged in admins can delete clothes
	if (empty($_SESSION['username'])) {
		header("Location: login.php");
		exit;
	}
	$mine = (int)($_SESSION['charity_id'] ?? 0);
if (empty($_SESSION['is_admin']) && !$mine) { header("Location: dashboard.php"); exit; }

	$id = (int)($_GET['id'] ?? 0);

	//A charity account may only delete its own needs
	if (empty($_SESSION['is_admin'])) {
		$own = $conn->prepare("SELECT charity_id FROM clothes WHERE id=:id"); $own->execute([':id'=>$id]);
		if ((int)$own->fetchColumn() !== $mine) { header("Location: dashboard.php"); exit; }
	}

	if ($id > 0) {
		$sql = "DELETE FROM clothes WHERE id=:id";
		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id, PDO::PARAM_INT);

		try {
			$prep->execute();
		} catch (PDOException $e) {
			//23000 = the movie is still referenced by other rows (for example donations)
			if ($e->getCode() == 23000) {
				die("This cloth cannot be deleted because it has donations. <a href='list_clothes.php'>Go back</a>");
			}
			error_log($e->getMessage());
			die("Delete failed. Please try again.");
		}
	}

	header("Location: list_clothes.php");
	exit;