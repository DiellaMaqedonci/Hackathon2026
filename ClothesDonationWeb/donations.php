<?php
/* Creating a session based on a session identifier, passed via a GET or POST request.
   We include config.php for the database connection.
*/

session_start();

include_once('config.php');

// Only logged in users can see donations
if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user_id  = (int)$_SESSION['id'];
$is_admin = !empty($_SESSION['is_admin']);

/*
If the user is admin we fetch all donations and show an option to approve or decline each one
(links to approve.php and decline.php). If the user is not admin we only fetch their own donations.
*/
if ($is_admin) {
    $sql = "SELECT clothes.cloth_name, users.email, donations.id, donations.nr_donations,
                   donation.date, donation.is_approved, donations.time
            FROM donations
            INNER JOIN donations ON clothes.id = donations.cloth_id
            INNER JOIN users ON users.id = donations.user_id
            ORDER BY donations.date DESC";

    $selectDonations = $conn->prepare($sql);
    $selectDonations->execute();
    $donations_data = $selectDonations->fetchAll();
} else {
    $sql = "SELECT clothes.cloth_name, users.email, donations.id, donations.nr_donations,
                   donations.date, donation.is_approved, donations.time
            FROM clothes
            INNER JOIN donations ON clothes.id = donations.cloth_id
            INNER JOIN users ON users.id = donations.user_id
            WHERE donations.user_id = :user_id
            ORDER BY donations.date DESC";

    $selectDonations = $conn->prepare($sql);
    $selectDonations->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $selectDonations->execute();
    $donations_data = $selectDonations->fetchAll();
}
?>

<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>My pledges · Spare Thread</title>
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
    <li class="nav-item"><a class="nav-link active" href="donations.php">My pledges</a></li>
    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="editUsers.php">Users</a></li>
    <li class="nav-item ms-md-2"><a class="btn btn-primary btn-sm px-3" href="login.php">Log in</a></li>
  </ul></div>
</div></nav>
<main class="flex-grow-1">

<div class="container">
  <div class="page-head"><h1>My pledges</h1><p class="text-secondary mb-0">Track what you've promised and what the charity has confirmed.</p></div>
  <div class="panel p-0 overflow-hidden"><div class="table-responsive"><table class="table align-middle mb-0">
    <thead><tr><th>Item</th><th>Charity</th><th>Qty</th><th>Drop-off</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <tr><td class="fw-semibold">Winter coats (M)</td><td>Hope Shelter</td><td>6</td><td>28 Nov, 10:00</td>
        <td><span class="badge rounded-pill status-booked">Booked</span></td>
        <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="details.php">Change</a>
          <a class="btn btn-sm btn-outline-danger" href="cancel.php?id=1" data-confirm="Cancel this pledge?">Cancel</a></td></tr>
      <tr><td class="fw-semibold">Thermal socks (S)</td><td>Care Circle</td><td>8</td><td>20 Nov, 14:00</td>
        <td><span class="badge rounded-pill status-arrived">Arrived</span></td><td></td></tr>
      <tr><td class="fw-semibold">Wool sweaters (L)</td><td>Hope Shelter</td><td>4</td><td>18 Nov, 11:00</td>
        <td><span class="badge rounded-pill status-arrived">Arrived</span></td><td></td></tr>
      <tr><td class="fw-semibold">Children's boots (32)</td><td>Little Steps</td><td>2</td><td>15 Nov, 09:00</td>
        <td><span class="badge rounded-pill status-late">Not received</span></td><td></td></tr>
    </tbody>
  </table></div></div>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>

