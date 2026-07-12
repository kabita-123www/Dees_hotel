<?php
require_once 'config/db.php';
$page_title = 'Facilities';

$facilities = $pdo->query("SELECT * FROM facilities ORDER BY id ASC")->fetchAll();

$icons = [
    'Fitness Center' => 'bi-heart-pulse',
    'Banquet Hall'   => 'bi-people',
    'Sauna'          => 'bi-droplet-half',
    'Bar'            => 'bi-cup-straw',
    'Swimming Pool'  => 'bi-water',
    'Restaurant'     => 'bi-egg-fried',
];

require_once 'includes/header.php';
?>



<!-- ============ FACILITIES LIST ============ -->
<section class="section-padding bg-cream">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Enjoy Every Moment</span>
      <h2 class="section-title">Everything You Need, Beautifully Delivered</h2>
      <hr class="divider-gold">
    </div>

    <div class="row g-4 pt-3">
      <?php foreach ($facilities as $f):
        $icon = $icons[$f['name']] ?? 'bi-star';
      ?>
      <div class="col-lg-4 col-md-6">
        <div class="luxury-card text-center pt-4">
          <div class="facility-icon-circle"><i class="bi <?php echo $icon; ?>"></i></div>
          <div class="card-img-wrap" style="height:200px;">
            <img src="<?php echo BASE_URL . htmlspecialchars($f['image']); ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=800'"
                 alt="<?php echo htmlspecialchars($f['name']); ?>">
          </div>
          <div class="card-body">
            <h4><?php echo htmlspecialchars($f['name']); ?></h4>
            <p style="color:var(--color-text-muted); font-size:0.92rem;">
              <?php echo htmlspecialchars($f['description']); ?>
            </p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
