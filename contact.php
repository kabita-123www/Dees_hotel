<?php
require_once 'config/db.php';
$page_title = 'Contact';
require_once 'includes/header.php';
?>


<!-- ============ CONTACT SECTION ============ -->
<section class="section-padding bg-cream">
  <div class="container">
    <div class="row g-5">
      <!-- Contact Info -->
      <div class="col-lg-4">
        <span class="section-eyebrow">Contact Us</span>
        <h2 class="section-title mb-4">We'd Love to Hear From You</h2>

        <div class="contact-info-item">
          <div class="icon-box"><i class="bi bi-geo-alt"></i></div>
          <div>
            <h5 class="mb-1">Address</h5>
            <p class="mb-0">Sri Shanta Marg, Kathmandu, Nepal 44600</p>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="icon-box"><i class="bi bi-telephone"></i></div>
          <div>
            <h5 class="mb-1">Phone</h5>
            <p class="mb-0">+977-9851358914</p>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="icon-box"><i class="bi bi-envelope"></i></div>
          <div>
            <h5 class="mb-1">Email</h5>
            <p class="mb-0">info@deeshotel.com</p>
          </div>
        </div>
        <div class="contact-info-item">
          <div class="icon-box"><i class="bi bi-clock"></i></div>
          <div>
            <h5 class="mb-1">Front Desk</h5>
            <p class="mb-0">Open 24 Hours</p>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-8">
        <form id="contactForm" class="form-luxury">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number</label>
              <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Message</label>
              <textarea name="message" rows="5" class="form-control" required></textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-gold">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Google Map -->
    <div class="row mt-5">
  <div class="col-12">
    <div class="map-wrap">
      <iframe
        src="https://www.google.com/maps?q=Dees+Boutique+Hotel+Shri+Shanta+Marg+Koteshwor+Kathmandu&output=embed"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
        title="Dees Boutique Hotel Location - Shri Shanta Marg, Koteshwor, Kathmandu">
      </iframe>
    </div>
  </div>
</div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
