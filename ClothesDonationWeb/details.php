<?php 
  /*Creating a session  based on a session identifier, passed via a GET or POST request.
  We will include config.php for connection with database.
  We will get the data of films from database based on each films ids.
  Creating a form which will post some of those datas into donate.php file
  */
	session_start();
  
   include_once('config.php');
   $id = $_GET['id'];
   $_SESSION['movie_id'] = $id;
   $sql = "SELECT * FROM clothes WHERE id=:id";
   $selectCloth = $conn->prepare($sql);
   $selectCloth->bindParam(":id",$id);
   $selectCloth->execute();
   $cloth_data = $selectCloth->fetch();
?>

<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Request details · Spare Thread</title>
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
  <div class="page-head"><a href="list_clothes.php" class="small"><i class="bi bi-arrow-left"></i> All needs</a>
    <h1 class="mt-2">Winter coats <span class="text-secondary fw-normal">· size M</span></h1></div>
  <div class="row g-4">
    <div class="col-lg-7"><div class="panel">
      <div class="d-flex justify-content-between mb-1"><strong>12 of 20 pledged</strong><span class="text-secondary">8 still needed</span></div>
      <div class="progress mb-4"><div class="progress-bar" style="width:60%"></div></div>
      <dl class="row mb-0">
        <dt class="col-sm-4">Charity</dt><dd class="col-sm-8">Hope Shelter</dd>
        <dt class="col-sm-4">Season</dt><dd class="col-sm-8"><span class="season">Winter</span></dd>
        <dt class="col-sm-4">Needed by</dt><dd class="col-sm-8">30 Nov</dd>
        <dt class="col-sm-4">Drop-off</dt><dd class="col-sm-8">Rr. Nëna Terezë 12, Pristina · Mon–Sat</dd>
        <dt class="col-sm-4">Condition</dt><dd class="col-sm-8 mb-0">Clean, no stains or damaged zippers. Please no heavily worn items.</dd>
      </dl>
    </div></div>
    <div class="col-lg-5"><form id="pledgeForm" method="post" action="details.php?id=1" class="panel">
      <h2 class="h4 mb-3">Pledge and book a drop-off</h2>
      <div class="mb-3"><label class="form-label" for="qty">How many pieces?</label>
        <input type="number" class="form-control" id="qty" name="qty" min="1" max="8" value="1">
        <div class="invalid-feedback">Enter a number between 1 and 8.</div></div>
      <div class="mb-3"><label class="form-label" for="date">Drop-off day</label>
        <input type="date" class="form-control" id="date" name="date" required></div>
      <div class="mb-4"><span class="form-label d-block">Time slot</span><div class="d-flex flex-wrap gap-2">
        <input type="radio" class="btn-check" name="slot" id="s0" value="09:00" checked><label class="btn btn-outline-primary slot-btn" for="s0">09:00</label>
        <input type="radio" class="btn-check" name="slot" id="s1" value="10:00"><label class="btn btn-outline-primary slot-btn" for="s1">10:00</label>
        <input type="radio" class="btn-check" name="slot" id="s2" value="11:00"><label class="btn btn-outline-primary slot-btn" for="s2">11:00</label>
        <input type="radio" class="btn-check" name="slot" id="s3" value="14:00"><label class="btn btn-outline-primary slot-btn" for="s3">14:00</label>
        <input type="radio" class="btn-check" name="slot" id="s4" value="16:00"><label class="btn btn-outline-primary slot-btn" for="s4">16:00</label>
      </div></div>
      <button class="btn btn-thread w-100 py-2">Confirm pledge</button>
    </form></div>
  </div>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>