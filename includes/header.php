<?php
// Determine current page for active nav highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title . ' | Dees Boutique Hotel' : 'Dees Boutique Hotel'; ?></title>
<meta name="description" content="Dees Boutique Hotel — Elegant luxury stays in the heart of Kathmandu, Nepal.">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Great+Vibes&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- Bootstrap 5 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

<!-- Custom Styles -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>

<!-- ============ NAVBAR ============ -->
<nav class="navbar navbar-expand-lg navbar-luxury fixed-top">
  <div class="container">
   <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">
  <img src="<?php echo BASE_URL; ?>uploads/logo.png" alt="" class="navbar-logo">
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
  <ul class="navbar-nav mx-lg-auto align-items-lg-center">
    <li class="nav-item"><a class="nav-link <?php echo $current_page=='index.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>index.php">Home</a></li>
    <li class="nav-item"><a class="nav-link <?php echo $current_page=='accommodations.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>accommodations.php">Accommodations</a></li>
    <li class="nav-item"><a class="nav-link <?php echo $current_page=='facilities.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>facilities.php">Facilities</a></li>
    <li class="nav-item"><a class="nav-link <?php echo $current_page=='gallery.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>gallery.php">Gallery</a></li>
    <li class="nav-item"><a class="nav-link <?php echo $current_page=='contact.php'?'active':''; ?>" href="<?php echo BASE_URL; ?>contact.php">Contact</a></li>
  </ul>
  <a class="btn btn-gold btn-sm mt-3 mt-lg-0" href="#" onclick="bookNowAlert(event)">Book Now</a>
</div>
  </div>
</nav>
