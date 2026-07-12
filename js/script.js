/* =========================================================
   Dees Boutique Hotel — Main JavaScript
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

  /* ---------- Navbar shrink on scroll ---------- */
  const nav = document.querySelector('.navbar-luxury');
  if (nav) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 60) {
        nav.style.padding = '6px 0';
        nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
      } else {
        nav.style.padding = '14px 0';
        nav.style.boxShadow = 'none';
      }
    });
  }

  /* ---------- Hero Slideshow (auto-play) ---------- */
  const slides = document.querySelectorAll('.hero-slide');
  const dotsWrap = document.querySelector('.hero-dots');
  if (slides.length > 0) {
    let current = 0;

    // Build dots dynamically
    if (dotsWrap) {
      slides.forEach((_, i) => {
        const dot = document.createElement('span');
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => showSlide(i));
        dotsWrap.appendChild(dot);
      });
    }

    function showSlide(index) {
      slides[current].classList.remove('active');
      if (dotsWrap) dotsWrap.children[current].classList.remove('active');
      current = (index + slides.length) % slides.length;
      slides[current].classList.add('active');
      if (dotsWrap) dotsWrap.children[current].classList.add('active');
    }

    slides[0].classList.add('active');
    setInterval(() => showSlide(current + 1), 5000);
  }

  /* ---------- Gallery Filter ---------- */
  const filterBtns = document.querySelectorAll('.gallery-filter-btn');
  const galleryItems = document.querySelectorAll('.gallery-item');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const filter = this.dataset.filter;
      galleryItems.forEach(item => {
        if (filter === 'all' || item.dataset.category === filter) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  /* ---------- Lightbox ---------- */
  const lightbox = document.getElementById('lightboxOverlay');
  const lightboxImg = document.getElementById('lightboxImg');
  const galleryImages = Array.from(document.querySelectorAll('.gallery-item img'));
  let lightboxIndex = 0;

  function openLightbox(index) {
    if (!lightbox) return;
    lightboxIndex = index;
    lightboxImg.src = galleryImages[lightboxIndex].src;
    lightbox.classList.add('show');
  }
  function closeLightbox() {
    lightbox.classList.remove('show');
  }
  function changeLightbox(step) {
    lightboxIndex = (lightboxIndex + step + galleryImages.length) % galleryImages.length;
    lightboxImg.src = galleryImages[lightboxIndex].src;
  }

  galleryImages.forEach((img, i) => {
    img.addEventListener('click', () => openLightbox(i));
  });
  const lbClose = document.querySelector('.lightbox-close');
  const lbPrev = document.querySelector('.lightbox-prev');
  const lbNext = document.querySelector('.lightbox-next');
  if (lbClose) lbClose.addEventListener('click', closeLightbox);
  if (lbPrev) lbPrev.addEventListener('click', () => changeLightbox(-1));
  if (lbNext) lbNext.addEventListener('click', () => changeLightbox(1));
  if (lightbox) {
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) closeLightbox();
    });
  }
  document.addEventListener('keydown', function (e) {
    if (!lightbox || !lightbox.classList.contains('show')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') changeLightbox(-1);
    if (e.key === 'ArrowRight') changeLightbox(1);
  });

  /* ---------- Contact Form (AJAX submit) ---------- */
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(contactForm);
      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Sending...';

      fetch('contact_process.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          showToast(data.message, data.success);
          if (data.success) contactForm.reset();
        })
        .catch(() => {
          showToast('Something went wrong. Please try again.', false);
        })
        .finally(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
    });
  }

});

/* ---------- Book Now placeholder ---------- */
function bookNowAlert(e) {
  e.preventDefault();
  showToast('Online booking is coming soon! Please call us at +977-1-4XXXXXX to reserve.', true);
}

/* ---------- Toast Helper ---------- */
function showToast(message, success = true) {
  const toastEl = document.getElementById('liveToast');
  const toastBody = document.getElementById('toastBody');
  if (!toastEl || !toastBody) { alert(message); return; }
  toastBody.textContent = message;
  toastEl.style.background = success ? 'var(--color-dark)' : '#7a2e2e';
  const toast = new bootstrap.Toast(toastEl);
  toast.show();
}
