<?php 
/*Creating a session  based on a session identifier, passed via a GET or POST request.
  Creating a form which users will use to give some movie data, then we will post those datas into addClothes.php file
*/

  session_start();

  //Only logged in users can open this page
  if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
  }

  //Only admins can add movies
  $is_admin = !empty($_SESSION['is_admin']);
  if (!$is_admin) {
    header("Location: dashboard.php");
    exit;
  }

 ?>

 <!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Post a need · Spare Thread</title>
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

<div class="container" style="max-width:820px">
  <div class="page-head"><h1>Post a need</h1><p class="text-secondary mb-0">Be specific. Exact sizes and quantities mean donors bring the right things.</p></div>
  <form method="post" action="clothes.php" class="panel"><div class="row g-3">
    <div class="col-md-8"><label class="form-label" for="item">What is needed?</label><input class="form-control" id="item" name="item" placeholder="e.g. Winter coats" required></div>
    <div class="col-md-4"><label class="form-label" for="category">Category</label>
      <select class="form-select" id="category" name="category"><option>Coats</option><option>Tops</option><option>Trousers</option><option>Shoes</option><option>Socks &amp; underwear</option><option>Accessories</option></select></div>
    <div class="col-6 col-md-3"><label class="form-label" for="size">Size</label>
      <select class="form-select" id="size" name="size"><option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option><option>XXL</option><option>Kids 2–6</option><option>Kids 7–12</option></select></div>
    <div class="col-6 col-md-3"><label class="form-label" for="season">Season</label>
      <select class="form-select" id="season" name="season"><option>Winter</option><option>Spring</option><option>Summer</option><option>Autumn</option><option>All year</option></select></div>
    <div class="col-6 col-md-3"><label class="form-label" for="qty">Quantity</label><input type="number" min="1" class="form-control" id="qty" name="qty" value="10"></div>
    <div class="col-6 col-md-3"><label class="form-label" for="deadline">Needed by</label><input type="date" class="form-control" id="deadline" name="deadline"></div>
    <div class="col-12"><label class="form-label" for="notes">Condition &amp; notes</label><textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Clean, no stains, no zipper damage…"></textarea></div>
  </div>
  <div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary px-4">Save request</button>
    <a class="btn btn-outline-secondary" href="dashboard.php">Cancel</a>
  </div></form>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>