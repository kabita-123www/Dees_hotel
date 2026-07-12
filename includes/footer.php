<!-- ============ FOOTER ============ -->
<footer class="footer-luxury">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="footer-brand mb-2">Dees Boutique Hotel</div>
        <p>Experience exceptional comfort and authentic hospitality in the heart of Kathmandu</p>
        <div class="social-icons mt-3">
          <a href="https://www.facebook.com/DeesBoutiqueHotel/"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/deesboutiquehotel/"><i class="bi bi-instagram"></i></a>
          <a href="https://wa.me/9779851358914"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
          <li><a href="<?php echo BASE_URL; ?>accommodations.php">Accommodations</a></li>
          <li><a href="<?php echo BASE_URL; ?>facilities.php">Facilities</a></li>
          <li><a href="<?php echo BASE_URL; ?>gallery.php">Gallery</a></li>
          <li><a href="<?php echo BASE_URL; ?>contact.php">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5>Facilities</h5>
        <ul>
          <li><a href="<?php echo BASE_URL; ?>facilities.php">Comfortable Rooms</a></li>
          <li><a href="<?php echo BASE_URL; ?>facilities.php"> Indoor Swimming Pool</a></li>
          <li><a href="<?php echo BASE_URL; ?>facilities.php"> RoofTop Restaurant &amp; </a></li>
          <li><a href="<?php echo BASE_URL; ?>facilities.php">Banquet Hall</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5>Contact Us</h5>
        <ul>
          <li><i class="bi bi-geo-alt me-2"></i> Sri Shanta Marg, Kathmandu, Nepal 44600</li>
          <li><i class="bi bi-telephone me-2"></i> +977-9851358914</li>
          <li><i class="bi bi-envelope me-2"></i> info@deeshotel.com</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; <?php echo date('Y'); ?> Dees Boutique Hotel. All Rights Reserved.
    </div>
  </div>
</footer>

<!-- Toast container for Book Now / form feedback -->
<div class="toast-luxury">
  <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" style="background: var(--color-dark);" data-bs-delay="3500">
    <div class="d-flex">
      <div class="toast-body" id="toastBody">Message</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo BASE_URL; ?>js/script.js"></script>
</body>
</html>
