<?php 
/*Creating a session  based on a session identifier, passed via a GET or POST request.
  We will include config.php for connection with database.
  We will fetch all datas from users in database and show them.
  If a user is admin, he can update or delete a user data.
  */
	session_start();

	include_once('config.php');

	if (empty($_SESSION['username'])) {
		header("Location: login.php");
		exit;
	}

	$is_admin = !empty($_SESSION['is_admin']);

	//Only admins see the users table, so only query it for admins (and only the needed columns)
	$users_data = [];
	if ($is_admin) {
		$sql = "SELECT id, name, username, email FROM users";
		$selectUsers = $conn->prepare($sql);
		$selectUsers->execute();

		$users_data = $selectUsers->fetchAll();
	}

 ?>

 <!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard · Spare Thread</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
</head><body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-md site-nav sticky-top"><div class="container">
  <a class="navbar-brand brand" href="index.php"><i class="bi bi-scissors"></i> Spare Thread</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-md-center gap-md-1">
    <li class="nav-item"><a class="nav-link" href="list_clothes.php">Browse needs</a></li>
    <li class="nav-item"><a class="nav-link" href="donations.php">My pledges</a></li>
    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="editUsers.php">Users</a></li>
    <li class="nav-item ms-md-2"><a class="btn btn-primary btn-sm px-3" href="login.php">Log in</a></li>
  </ul></div>
</div></nav>
<main class="flex-grow-1">

<div class="container">
  <div class="page-head d-flex flex-wrap justify-content-between align-items-end gap-2">
    <div><h1>Hope Shelter</h1><p class="text-secondary mb-0">Dashboard</p></div>
    <a class="btn btn-thread" href="clothes.php"><i class="bi bi-plus-lg"></i> Post a need</a>
  </div>
  <div class="row g-4 mb-4">
    <div class="col-6 col-lg-3"><div class="panel"><i class="bi bi-tags text-secondary"></i><div class="stat mt-2">4</div><div class="text-secondary">open requests</div></div></div>
    <div class="col-6 col-lg-3"><div class="panel"><i class="bi bi-hand-thumbs-up text-secondary"></i><div class="stat mt-2">20</div><div class="text-secondary">pieces pledged</div></div></div>
    <div class="col-6 col-lg-3"><div class="panel"><i class="bi bi-calendar-event text-secondary"></i><div class="stat mt-2">3</div><div class="text-secondary">drop-offs this week</div></div></div>
    <div class="col-6 col-lg-3"><div class="panel"><i class="bi bi-check2-circle text-secondary"></i><div class="stat mt-2">38</div><div class="text-secondary">pieces received</div></div></div>
  </div>
  <div class="row g-4">
    <div class="col-lg-7"><div class="panel">
      <h2 class="h4 mb-3">Incoming drop-offs</h2>
      <form method="post" action="dashboard.php">
        <ul class="list-group list-group-flush">
          <li class="list-group-item px-0 d-flex align-items-center gap-3">
            <input class="form-check-input mt-0" type="checkbox" name="arrived[]" value="1" id="a1" style="width:1.4rem;height:1.4rem">
            <label for="a1" class="flex-grow-1"><strong>Arta K.</strong> · 6 × Winter coats (M)<br><span class="small text-secondary">Sat 28 Nov, 10:00</span></label>
          </li>
          <li class="list-group-item px-0 d-flex align-items-center gap-3">
            <input class="form-check-input mt-0" type="checkbox" name="arrived[]" value="2" id="a2" style="width:1.4rem;height:1.4rem">
            <label for="a2" class="flex-grow-1"><strong>Besnik R.</strong> · 10 × Thermal socks (S)<br><span class="small text-secondary">Sat 28 Nov, 14:00</span></label>
          </li>
          <li class="list-group-item px-0 d-flex align-items-center gap-3">
            <input class="form-check-input mt-0" type="checkbox" name="arrived[]" value="3" id="a3" style="width:1.4rem;height:1.4rem">
            <label for="a3" class="flex-grow-1"><strong>Liridona M.</strong> · 4 × Wool sweaters (L)<br><span class="small text-secondary">Mon 30 Nov, 09:00</span></label>
          </li>
        </ul>
        <button id="arrivedBtn" class="btn btn-primary mt-3">Mark selected as arrived</button>
      </form>
    </div></div>
    <div class="col-lg-5"><div class="panel">
      <h2 class="h4 mb-3">Your requests</h2>
      <div class="mb-3"><div class="d-flex justify-content-between"><a class="fw-semibold text-decoration-none" href="edit.php?id=1">Winter coats (M)</a><span class="small text-secondary">12/20</span></div><div class="progress mt-1"><div class="progress-bar" style="width:60%"></div></div></div>
      <div class="mb-3"><div class="d-flex justify-content-between"><a class="fw-semibold text-decoration-none" href="edit.php?id=2">Children's boots (32)</a><span class="small text-secondary">3/15</span></div><div class="progress mt-1"><div class="progress-bar" style="width:20%"></div></div></div>
      <div class="mb-3"><div class="d-flex justify-content-between"><a class="fw-semibold text-decoration-none" href="edit.php?id=3">Wool sweaters (L)</a><span class="small text-secondary">10/10</span></div><div class="progress mt-1"><div class="progress-bar" style="width:100%"></div></div></div>
      <div class="mb-0"><div class="d-flex justify-content-between"><a class="fw-semibold text-decoration-none" href="edit.php?id=4">Thermal socks (S)</a><span class="small text-secondary">18/40</span></div><div class="progress mt-1"><div class="progress-bar" style="width:45%"></div></div></div>
    </div></div>
  </div>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>