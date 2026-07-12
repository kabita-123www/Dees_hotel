<?php
require_once 'config/db.php';
$page_title = 'Home';

// Fetch slideshow images
$slides = $pdo->query("SELECT * FROM slideshow ORDER BY id ASC")->fetchAll();

// Fetch featured facilities (limit 3)
$facilities = $pdo->query("SELECT * FROM facilities ORDER BY id ASC LIMIT 3")->fetchAll();

require_once 'includes/header.php';
?>

<!-- ============ HERO SLIDESHOW ============ -->
<section class="hero-slideshow">
  <?php if (count($slides) > 0): ?>
    <?php foreach ($slides as $slide): ?>
      <div class="hero-slide" style="background-image:url('<?php echo BASE_URL . htmlspecialchars($slide['image_path']); ?>');"></div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="hero-slide active" style="background-image:url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1600');"></div>
  <?php endif; ?>

  <div class="hero-caption">
    <span class="eyebrow">Welcome to</span>
    <h1>Dees Boutique Hotel</h1>
    <p class="mb-4" style="max-width:600px;">Elegant stays, warm hospitality, and timeless comfort in the heart of Kathmandu, Nepal.</p>
    <div class="d-flex gap-3 flex-wrap justify-content-center">
      <a href="accommodations.php" class="btn btn-gold">Explore Rooms</a>
      <a href="#" class="btn btn-outline-gold" onclick="bookNowAlert(event)" style="color:#fff !important; border-color:#fff;">Book Now</a>
    </div>
  </div>
  <div class="hero-dots"></div>
</section>

<!-- ============ ABOUT US ============ -->
<section class="section-padding bg-cream">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="about-img-wrap">
          <img src="uploads/About us.jpg" class="img-fluid w-100" alt="Dees Boutique Hotel lobby" style="height:460px; object-fit:cover;">
        </div>
      </div>
      <div class="col-lg-6">
        <span class="section-eyebrow">About Us</span>
        <h2 class="section-title">Experience Refined Comfort and Authentic Hospitality</h2>
        <hr class="divider-gold align-left">
        <p>Located in the vibrant center of the city, Dees Boutique Hotel provides a peaceful escape with a focus on personalized service. With a 4.8/5 guest rating and over a decade of experience, we pride ourselves on offering thoughtfully designed rooms and a quiet atmosphere. Whether you're here for business or leisure, enjoy a sophisticated stay in the heart of the city.</p>
        
        <div class="row mt-4">
          <div class="col-6">
            <h3 class="text-gradient-gold mb-0">12+</h3>
            <small class="text-uppercase" style="letter-spacing:1px; color:var(--color-text-muted);">Years of Service</small>
          </div>
          <div class="col-6">
            <h3 class="text-gradient-gold mb-0">4.8/5</h3>
            <small class="text-uppercase" style="letter-spacing:1px; color:var(--color-text-muted);">Guest Rating</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ FEATURED FACILITIES ============ -->
<section class="section-padding bg-dark-luxury">
  <div class="container text-center">
    <span class="section-eyebrow">What We Offer</span>
    <h2 class="section-title" style="color:#fff;">Featured Facilities</h2>
    <hr class="divider-gold">
    <div class="row g-4 mt-4">
      <?php foreach ($facilities as $f): ?>
      <div class="col-md-4">
        <div class="luxury-card text-center">
          <div class="card-img-wrap">
            <img src="<?php echo BASE_URL . htmlspecialchars($f['image']); ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=800'"
                 alt="<?php echo htmlspecialchars($f['name']); ?>">
          </div>
          <div class="card-body">
            <h4><?php echo htmlspecialchars($f['name']); ?></h4>
            <p class="mb-0" style="color:var(--color-text-muted); font-size:0.92rem;">
              <?php echo htmlspecialchars(mb_strimwidth($f['description'], 0, 90, '...')); ?>
            </p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <a href="facilities.php" class="btn btn-outline-gold mt-5">View All Facilities</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
