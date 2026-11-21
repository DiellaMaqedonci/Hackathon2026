<?php 
 /*
  We will include config.php for connection with database.
  We will fetch all datas from movies in database and show them.
  */
	
   include_once('config.php');

   $sql = "SELECT * FROM clothes";
   $selectClothes = $conn->prepare($sql);
   $selectClothes->execute();
   $clothes_data = $selectMovies->fetchAll();

 ?>

 <!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Home · Spare Thread</title>
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

<div class="container">
  <div class="page-head"><h1>Hello, Arta</h1><p class="text-secondary mb-0">Here's what's coming up and where you can help next.</p></div>
  <div class="row g-4 mb-5">
    <div class="col-lg-5"><div class="panel h-100 border-start border-4" style="border-left-color:var(--thread)!important">
      <div class="small text-secondary mb-1">Next drop-off</div>
      <h2 class="h4">Sat 28 Nov, 10:00–11:00</h2>
      <p class="mb-3">6 winter coats (M) to <strong>Hope Shelter</strong>, Rr. Nëna Terezë 12, Pristina</p>
      <a class="btn btn-primary btn-sm" href="donations.php">Manage pledge</a>
    </div></div>
    <div class="col-lg-7"><div class="row g-4 h-100">
      <div class="col-4"><div class="panel h-100"><div class="stat">14</div><div class="text-secondary">items pledged</div></div></div>
      <div class="col-4"><div class="panel h-100"><div class="stat">9</div><div class="text-secondary">items delivered</div></div></div>
      <div class="col-4"><div class="panel h-100"><div class="stat">3</div><div class="text-secondary">charities helped</div></div></div>
    </div></div>
  </div>
  <h2 class="mb-3">Urgent needs</h2>
  <div class="row g-4">
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=1"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">M</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Winter coats</h3><div class="small text-secondary mb-3">Hope Shelter · Pristina</div><div class="progress mb-1"><div class="progress-bar" style="width:60%"></div></div><div class="d-flex justify-content-between small"><span>12 of 20 pledged</span><span class="text-secondary">by 30 Nov</span></div></a></div>
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=2"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">32</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Children's boots</h3><div class="small text-secondary mb-3">Little Steps · Prizren</div><div class="progress mb-1"><div class="progress-bar" style="width:20%"></div></div><div class="d-flex justify-content-between small"><span>3 of 15 pledged</span><span class="text-secondary">by 05 Dec</span></div></a></div>
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=3"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">L</div><span class="season">Autumn</span></div><h3 class="h5 mb-1">Wool sweaters</h3><div class="small text-secondary mb-3">Hope Shelter · Pristina</div><div class="progress mb-1"><div class="progress-bar" style="width:100%"></div></div><div class="d-flex justify-content-between small"><span>10 of 10 pledged</span><span class="text-secondary">by 25 Nov</span></div></a></div>
    <div class="col-sm-6 col-lg-3"><a class="tag text-decoration-none" href="details.php?id=4"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">S</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Thermal socks</h3><div class="small text-secondary mb-3">Care Circle · Peja</div><div class="progress mb-1"><div class="progress-bar" style="width:45%"></div></div><div class="d-flex justify-content-between small"><span>18 of 40 pledged</span><span class="text-secondary">by 10 Dec</span></div></a></div>
  </div>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>