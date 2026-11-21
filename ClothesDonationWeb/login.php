<?php
session_start();

//Already logged in users don't need the login page
if (!empty($_SESSION['username'])) {
	header('Location: dashboard.php');
	exit;
}

//Show (once) the error message set by loginLogic.php
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Log in · Spare Thread</title>
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
    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="editUsers.php">Users</a></li>
    <li class="nav-item ms-md-2"><a class="btn btn-primary btn-sm px-3" href="login.php">Log in</a></li>
  </ul></div>
</div></nav>
<main class="flex-grow-1">

<div class="container py-5"><div class="row g-0 mx-auto shadow-sm" style="max-width:900px">
  <div class="col-md-5 auth-side p-5 d-flex flex-column justify-content-center">
    <h1 class="h2">Welcome back</h1>
    <p class="mb-0 text-white-50">Donors manage pledges. Charities manage needs and tick off what arrived.</p>
  </div>
  <div class="col-md-7 bg-white p-5 border rounded-end-3">
    <form method="post" action="login.php">
      <div class="mb-3"><label class="form-label" for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required autofocus></div>
      <div class="mb-3"><label class="form-label" for="password">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" required>
          <button type="button" class="btn btn-outline-secondary" id="togglePw" aria-label="Show password"><i class="bi bi-eye"></i></button>
        </div></div>
      <div class="d-flex justify-content-between mb-4"><div class="form-check"><input class="form-check-input" type="checkbox" id="rem"><label class="form-check-label" for="rem">Remember me</label></div><a href="#">Forgot password?</a></div>
      <button class="btn btn-primary w-100 py-2">Log in</button>
      <p class="text-center text-secondary mt-4 mb-0">New here? <a href="#">Create an account</a></p>
    </form>
  </div>
</div></div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>