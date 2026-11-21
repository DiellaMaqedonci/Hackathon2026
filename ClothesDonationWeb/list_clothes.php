<?php 
 /*Creating a session  based on a session identifier, passed via a GET or POST request.
  We will include config.php for connection with database.
  We will fetch all datas from movies in database and show them.
  */

	  session_start();

    include_once('config.php');

    if (empty($_SESSION['username'])) {
          header("Location: login.php");
    }
   
    $sql = "SELECT * FROM clothes";
    $selectUsers = $conn->prepare($sql);
    $selectUsers->execute();

    $users_data = $selectUsers->fetchAll();
    
 ?>

 <!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Browse needs · Spare Thread</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
</head><body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-md site-nav sticky-top"><div class="container">
  <a class="navbar-brand brand" href="index.php"><i class="bi bi-scissors"></i> Spare Thread</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-md-center gap-md-1">
    <li class="nav-item"><a class="nav-link active" href="list_clothes.php">Browse needs</a></li>
    <li class="nav-item"><a class="nav-link" href="donations.php">My pledges</a></li>
    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="editUsers.php">Users</a></li>
    <li class="nav-item ms-md-2"><a class="btn btn-primary btn-sm px-3" href="login.php">Log in</a></li>
  </ul></div>
</div></nav>
<main class="flex-grow-1">

<div class="container">
  <div class="page-head d-flex flex-wrap justify-content-between align-items-end gap-2">
    <div><h1>What's needed</h1><p class="text-secondary mb-0">Open requests from charities near you</p></div>
    <a class="btn btn-thread" href="clothes.php"><i class="bi bi-plus-lg"></i> Post a need</a>
  </div>
  <form id="filterForm" class="panel mb-4"><div class="row g-3 align-items-end">
    <div class="col-md-4"><label class="form-label" for="q">Search</label><input class="form-control" id="q" placeholder="Coats, boots…"></div>
    <div class="col-6 col-md-3"><label class="form-label" for="season">Season</label>
      <select class="form-select" id="season"><option value="">Any</option><option>Winter</option><option>Spring</option><option>Summer</option><option>Autumn</option></select></div>
    <div class="col-6 col-md-2"><label class="form-label" for="size">Size</label>
      <select class="form-select" id="size"><option value="">Any</option><option>S</option><option>M</option><option>L</option><option>XL</option><option>32</option></select></div>
    <div class="col-md-3"><label class="form-label" for="city">City</label>
      <select class="form-select" id="city"><option value="">All</option><option>Pristina</option><option>Prizren</option><option>Peja</option></select></div>
  </div></form>

  <div class="row g-4">
    <div class="col-sm-6 col-lg-4 col-xl-3 need-col" data-item="Winter coats" data-season="Winter" data-size="M" data-city="Pristina"><a class="tag text-decoration-none" href="details.php?id=1"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">M</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Winter coats</h3><div class="small text-secondary mb-3">Hope Shelter · Pristina</div><div class="progress mb-1"><div class="progress-bar" style="width:60%"></div></div><div class="d-flex justify-content-between small"><span>12 of 20 pledged</span><span class="text-secondary">by 30 Nov</span></div></a></div>
    <div class="col-sm-6 col-lg-4 col-xl-3 need-col" data-item="Children's boots" data-season="Winter" data-size="32" data-city="Prizren"><a class="tag text-decoration-none" href="details.php?id=2"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">32</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Children's boots</h3><div class="small text-secondary mb-3">Little Steps · Prizren</div><div class="progress mb-1"><div class="progress-bar" style="width:20%"></div></div><div class="d-flex justify-content-between small"><span>3 of 15 pledged</span><span class="text-secondary">by 05 Dec</span></div></a></div>
    <div class="col-sm-6 col-lg-4 col-xl-3 need-col" data-item="Wool sweaters" data-season="Autumn" data-size="L" data-city="Pristina"><a class="tag text-decoration-none" href="details.php?id=3"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">L</div><span class="season">Autumn</span></div><h3 class="h5 mb-1">Wool sweaters</h3><div class="small text-secondary mb-3">Hope Shelter · Pristina</div><div class="progress mb-1"><div class="progress-bar" style="width:100%"></div></div><div class="d-flex justify-content-between small"><span>10 of 10 pledged</span><span class="text-secondary">by 25 Nov</span></div></a></div>
    <div class="col-sm-6 col-lg-4 col-xl-3 need-col" data-item="Thermal socks" data-season="Winter" data-size="S" data-city="Peja"><a class="tag text-decoration-none" href="details.php?id=4"><div class="d-flex justify-content-between align-items-start mb-2"><div class="size">S</div><span class="season">Winter</span></div><h3 class="h5 mb-1">Thermal socks</h3><div class="small text-secondary mb-3">Care Circle · Peja</div><div class="progress mb-1"><div class="progress-bar" style="width:45%"></div></div><div class="d-flex justify-content-between small"><span>18 of 40 pledged</span><span class="text-secondary">by 10 Dec</span></div></a></div>
  </div>
  <p id="emptyMsg" class="text-center text-secondary py-5" hidden>No requests match those filters. Try clearing one.</p>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>