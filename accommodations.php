<?php
require_once 'config/db.php';
$page_title = 'Accommodations';

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY price ASC")->fetchAll();

require_once 'includes/header.php';
?>



<!-- ============ ROOMS LIST ============ -->
<section class="section-padding bg-cream">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Stay With Us</span>
      <h2 class="section-title">Rooms &amp; Suites</h2>
      <hr class="divider-gold">
      <p class="mx-auto" style="max-width:600px;">Each room is designed to offer comfort, elegance, and a personal touch — choose the space that suits your journey.</p>
    </div>

    <div class="row g-4">
      <?php if (count($rooms) === 0): ?>
        <p class="text-center">No rooms available at the moment. Please check back soon.</p>
      <?php endif; ?>

      <?php foreach ($rooms as $room):
        $features = array_filter(array_map('trim', explode(',', $room['features'])));
      ?>
      <div class="col-lg-4 col-md-6">
        <div class="luxury-card">
          <div class="card-img-wrap">
            <img src="<?php echo BASE_URL . htmlspecialchars($room['image']); ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=900'"
                 alt="<?php echo htmlspecialchars($room['type']); ?>">
          </div>
          <div class="card-body">
            <h4><?php echo htmlspecialchars($room['type']); ?></h4>
            <p style="color:var(--color-text-muted); font-size:0.92rem; min-height:66px;">
              <?php echo htmlspecialchars($room['description']); ?>
            </p>
            <div class="mb-3">
              <?php foreach ($features as $feat): ?>
                <span class="feature-badge"><?php echo htmlspecialchars($feat); ?></span>
              <?php endforeach; ?>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="price-tag">NPR <?php echo number_format($room['price'], 0); ?> <span>/ night</span></div>
              <a href="#" class="btn btn-gold btn-sm" onclick="bookNowAlert(event)">Book Now</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
