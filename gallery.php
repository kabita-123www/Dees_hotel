<?php
require_once 'config/db.php';
$page_title = 'Gallery';

$images = $pdo->query("SELECT * FROM gallery ORDER BY id ASC")->fetchAll();
$categories = array_unique(array_column($images, 'category'));

require_once 'includes/header.php';
?>



<!-- ============ GALLERY GRID ============ -->
<section class="section-padding bg-cream">
  <div class="container">
    <div class="text-center mb-4">
      <span class="section-eyebrow">Take a Look</span>
      <h2 class="section-title">Moments at Dees</h2>
      <hr class="divider-gold">
    </div>

    <div class="text-center mb-5">
      <button class="gallery-filter-btn active" data-filter="all">All</button>
      <?php foreach ($categories as $cat): ?>
        <button class="gallery-filter-btn" data-filter="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></button>
      <?php endforeach; ?>
    </div>

    <div class="row g-3">
      <?php if (count($images) === 0): ?>
        <p class="text-center">No images in the gallery yet.</p>
      <?php endif; ?>
      <?php foreach ($images as $img): ?>
      <div class="col-lg-4 col-md-6 gallery-item" data-category="<?php echo htmlspecialchars($img['category']); ?>">
        <img src="<?php echo BASE_URL . htmlspecialchars($img['image_path']); ?>"
             onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800'"
             alt="Gallery image">
        <div class="gallery-overlay"><span><?php echo htmlspecialchars($img['category']); ?></span></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ LIGHTBOX ============ -->
<div class="lightbox-overlay" id="lightboxOverlay">
  <span class="lightbox-close"><i class="bi bi-x-lg"></i></span>
  <span class="lightbox-prev"><i class="bi bi-chevron-left"></i></span>
  <img src="" alt="Preview" id="lightboxImg">
  <span class="lightbox-next"><i class="bi bi-chevron-right"></i></span>
</div>

<?php require_once 'includes/footer.php'; ?>
