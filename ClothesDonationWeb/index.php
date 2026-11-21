<?php
session_start();

//Already logged in users don't need the registration page
if (!empty($_SESSION['username'])) {
	header('Location: dashboard.php');
	exit;
}

//Show (once) the error message and previously typed values set by register.php, if any
$error = $_SESSION['register_error'] ?? null;
$old = $_SESSION['register_old'] ?? [];
unset($_SESSION['register_error'], $_SESSION['register_old']);
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Spare Thread</title>
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

<section class="hero"><div class="container"><div class="row align-items-center g-5">
  <div class="col-lg-6">
    <h1>Charities say exactly what they need.</h1>
    <p class="mt-3 mb-4">Sizes, seasons, quantities. You pledge what you have, pick a drop-off time, and the charity ticks it off when it arrives. No guesswork, no pile of wrong-sized coats.</p>
    <a class="btn btn-thread btn-lg px-4 me-2" href="list_clothes.php">See what's needed</a>
    <a class="btn btn-outline-light btn-lg" href="login.php">I'm a charity</a>
  </div>
  <div class="col-lg-6"><div class="stack" aria-hidden="true">
    <div class="tag"><div class="d-flex justify-content-between"><div class="size">M</div><span class="season">Winter</span></div><h3 class="h5 mt-2 mb-0">Winter coats</h3><div class="small text-secondary">12 of 20 pledged</div></div>
    <div class="tag"><div class="d-flex justify-content-between"><div class="size">32</div><span class="season">Winter</span></div><h3 class="h5 mt-2 mb-0">Children's boots</h3><div class="small text-secondary">3 of 15 pledged</div></div>
    <div class="tag"><div class="d-flex justify-content-between"><div class="size">L</div><span class="season">Autumn</span></div><h3 class="h5 mt-2 mb-0">Wool sweaters</h3><div class="small text-secondary">10 of 10 pledged</div></div>
  </div></div>
</div></div></section>

<section class="container py-5">
  <h2 class="mb-4">How it works</h2>
  <div class="row g-4">
    <div class="col-sm-6 col-lg-3"><div class="panel h-100"><div class="size mb-2">1</div><h3 class="h5">Charity posts a need</h3><p class="mb-0 text-secondary">Item, size, season and how many pieces.</p></div></div>
    <div class="col-sm-6 col-lg-3"><div class="panel h-100"><div class="size mb-2">2</div><h3 class="h5">You pledge</h3><p class="mb-0 text-secondary">Choose a request and say how many you can give.</p></div></div>
    <div class="col-sm-6 col-lg-3"><div class="panel h-100"><div class="size mb-2">3</div><h3 class="h5">Book a drop-off</h3><p class="mb-0 text-secondary">Pick a day and time slot that suits you.</p></div></div>
    <div class="col-sm-6 col-lg-3"><div class="panel h-100"><div class="size mb-2">4</div><h3 class="h5">Charity ticks it off</h3><p class="mb-0 text-secondary">Arrived items are marked so the count stays honest.</p></div></div>
  </div>
</section>

<section class="container pb-4">
  <div class="d-flex justify-content-between align-items-end mb-3"><h2 class="mb-0">Most needed right now</h2><a href="list_clothes.php">View all</a></div>
  <div class="row g-4">
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=1"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">M</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Winter coats</h3><div class="small text-secondary mb-3">Hope Shelter · Pristina</div><div class="progress mb-1"><div class="progress-bar" style="width:60%"></div></div><div class="d-flex justify-content-between small"><span>12 of 20 pledged</span><span class="text-secondary">by 30 Nov</span></div></a></div>
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=2"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">32</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Children's boots</h3><div class="small text-secondary mb-3">Little Steps · Prizren</div><div class="progress mb-1"><div class="progress-bar" style="width:20%"></div></div><div class="d-flex justify-content-between small"><span>3 of 15 pledged</span><span class="text-secondary">by 05 Dec</span></div></a></div>
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=3"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">L</div><span class="season">Autumn</span></div><h3 class="h5 mb-1">Wool sweaters</h3><div class="small text-secondary mb-3">Hope Shelter · Pristina</div><div class="progress mb-1"><div class="progress-bar" style="width:100%"></div></div><div class="d-flex justify-content-between small"><span>10 of 10 pledged</span><span class="text-secondary">by 25 Nov</span></div></a></div>
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=4"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">S</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Thermal socks</h3><div class="small text-secondary mb-3">Care Circle · Peja</div><div class="progress mb-1"><div class="progress-bar" style="width:45%"></div></div><div class="d-flex justify-content-between small"><span>18 of 40 pledged</span><span class="text-secondary">by 10 Dec</span></div></a></div>
  </div>
</section>

</main>

<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>

</body>

</html>