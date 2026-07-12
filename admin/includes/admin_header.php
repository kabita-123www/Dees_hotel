<?php $current = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title . ' | Admin — Dees Boutique Hotel' : 'Admin Dashboard'; ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../css/style.css">
<style>
  body { background: var(--color-cream-2); font-family: var(--font-body); }
  .admin-sidebar {
    width: 250px; min-height: 100vh; position: fixed; left: 0; top: 0;
    background: var(--gradient-dark); color: #cfc3b3; padding-top: 20px; z-index: 100;
  }
  .admin-sidebar .brand { font-family: var(--font-script); color: var(--color-gold-light); font-size: 1.7rem; padding: 10px 24px 20px; display: block; }
  .admin-sidebar a { display: flex; align-items: center; gap: 10px; color: #cfc3b3; padding: 13px 24px; font-size: 0.92rem; border-left: 3px solid transparent; }
  .admin-sidebar a:hover, .admin-sidebar a.active { background: rgba(255,255,255,0.06); border-left-color: var(--color-gold); color: #fff; }
  .admin-content { margin-left: 250px; padding: 28px 32px; }
  .admin-topbar { display:flex; justify-content: space-between; align-items:center; margin-bottom: 24px; }
  .admin-card { background:#fff; border-radius:8px; padding:24px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); }
  .stat-card { background:#fff; border-radius:8px; padding:22px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); border-left: 4px solid var(--color-gold); }
  table.table thead { background: var(--color-dark); color: #fff; }
  .thumb { width: 60px; height: 45px; object-fit: cover; border-radius: 4px; }
  @media (max-width: 768px) {
    .admin-sidebar { width: 100%; min-height: auto; position: relative; }
    .admin-content { margin-left: 0; }
  }
</style>
</head>
<body>

<div class="admin-sidebar d-none d-md-block">
  <span class="brand">Dees Admin</span>
  <a href="dashboard.php" class="<?php echo $current=='dashboard.php'?'active':''; ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="slideshow.php" class="<?php echo $current=='slideshow.php'?'active':''; ?>"><i class="bi bi-images"></i> Slideshow</a>
  <a href="rooms.php" class="<?php echo $current=='rooms.php'?'active':''; ?>"><i class="bi bi-door-closed"></i> Rooms</a>
  <a href="facilities.php" class="<?php echo $current=='facilities.php'?'active':''; ?>"><i class="bi bi-stars"></i> Facilities</a>
  <a href="gallery.php" class="<?php echo $current=='gallery.php'?'active':''; ?>"><i class="bi bi-grid-3x3-gap"></i> Gallery</a>
  <a href="../index.php" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Site</a>
  <a href="logout.php"><i class="bi bi-power"></i> Logout</a>
</div>

<!-- Mobile top nav -->
<nav class="navbar navbar-dark d-md-none" style="background: var(--color-dark);">
  <div class="container-fluid">
    <span class="navbar-brand" style="font-family:var(--font-script); color:var(--color-gold-light);">Dees Admin</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMobileNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  <div class="collapse w-100" id="adminMobileNav">
    <div class="d-flex flex-column p-2">
      <a href="dashboard.php" class="text-light py-2">Dashboard</a>
      <a href="slideshow.php" class="text-light py-2">Slideshow</a>
      <a href="rooms.php" class="text-light py-2">Rooms</a>
      <a href="facilities.php" class="text-light py-2">Facilities</a>
      <a href="gallery.php" class="text-light py-2">Gallery</a>
      <a href="logout.php" class="text-light py-2">Logout</a>
    </div>
  </div>
</nav>

<div class="admin-content">
