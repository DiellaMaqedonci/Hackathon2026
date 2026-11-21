<?php 
 /*Creating a session  based on a session identifier, passed via a GET or POST request.
  We will include config.php for connection with database.
  We will fetch the data from database and show them, and create a form which will allow us to change the datas.
  */

	 session_start();

   include_once('config.php');

   $id = $_GET['id'];

   $sql = "SELECT * FROM users WHERE id=:id";
   $selectUser = $conn->prepare($sql);
   $selectUser->bindParam(':id', $id);
   $selectUser->execute();

   $user_data = $selectUser->fetch();
	

 ?>

 <!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Users · Spare Thread</title>
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
    <li class="nav-item"><a class="nav-link active" href="editUsers.php">Users</a></li>
    <li class="nav-item ms-md-2"><a class="btn btn-primary btn-sm px-3" href="login.php">Log in</a></li>
  </ul></div>
</div></nav>
<main class="flex-grow-1">

<div class="container">
  <div class="page-head"><h1>Users</h1><p class="text-secondary mb-0">Manage roles and approve charity accounts.</p></div>
  <form method="post" action="editUsers.php" class="panel p-0 overflow-hidden"><div class="table-responsive"><table class="table align-middle mb-0">
    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <tr><td class="fw-semibold">Arta Krasniqi</td><td>arta@mail.com</td>
        <td><select class="form-select form-select-sm" name="role[1]" style="width:130px"><option selected>donor</option><option>charity</option><option>admin</option></select></td>
        <td><span class="badge rounded-pill status-arrived">active</span></td>
        <td class="text-end"><button class="btn btn-sm btn-primary" name="save" value="1">Save</button>
          <button class="btn btn-sm btn-outline-danger" name="delete" value="1" data-confirm="Remove this user?"><i class="bi bi-trash"></i><span class="visually-hidden">Delete</span></button></td></tr>
      <tr><td class="fw-semibold">Hope Shelter</td><td>info@hope.org</td>
        <td><select class="form-select form-select-sm" name="role[2]" style="width:130px"><option>donor</option><option selected>charity</option><option>admin</option></select></td>
        <td><span class="badge rounded-pill status-arrived">active</span></td>
        <td class="text-end"><button class="btn btn-sm btn-primary" name="save" value="2">Save</button>
          <button class="btn btn-sm btn-outline-danger" name="delete" value="2" data-confirm="Remove this user?"><i class="bi bi-trash"></i><span class="visually-hidden">Delete</span></button></td></tr>
      <tr><td class="fw-semibold">Besnik Rama</td><td>besnik@mail.com</td>
        <td><select class="form-select form-select-sm" name="role[3]" style="width:130px"><option selected>donor</option><option>charity</option><option>admin</option></select></td>
        <td><span class="badge rounded-pill status-arrived">active</span></td>
        <td class="text-end"><button class="btn btn-sm btn-primary" name="save" value="3">Save</button>
          <button class="btn btn-sm btn-outline-danger" name="delete" value="3" data-confirm="Remove this user?"><i class="bi bi-trash"></i><span class="visually-hidden">Delete</span></button></td></tr>
      <tr><td class="fw-semibold">Care Circle</td><td>hello@care.org</td>
        <td><select class="form-select form-select-sm" name="role[4]" style="width:130px"><option>donor</option><option selected>charity</option><option>admin</option></select></td>
        <td><span class="badge rounded-pill status-booked">pending</span></td>
        <td class="text-end"><button class="btn btn-sm btn-primary" name="save" value="4">Save</button>
          <button class="btn btn-sm btn-outline-danger" name="delete" value="4" data-confirm="Remove this user?"><i class="bi bi-trash"></i><span class="visually-hidden">Delete</span></button></td></tr>
    </tbody>
  </table></div></form>
</div>

</main>
<footer class="footer mt-5 py-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small">
  <span><i class="bi bi-scissors text-warning"></i> Spare Thread · clothes to the people who need them</span><span>© 2026</span>
</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>