<?php
require_once 'includes/auth_check.php';
require_once '../config/db.php';
$page_title = 'Manage Gallery';

$upload_dir = '../uploads/gallery/';
$msg = ''; $msg_type = 'success';

// ---- ADD IMAGE ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $category = trim($_POST['category']) ?: 'General';

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $msg = 'Please choose an image to upload.'; $msg_type = 'danger';
    } else {
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $msg = 'Only JPG, PNG, WEBP images are allowed.'; $msg_type = 'danger';
        } else {
            $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                $stmt = $pdo->prepare("INSERT INTO gallery (image_path, category) VALUES (?, ?)");
                $stmt->execute(['uploads/gallery/' . $filename, $category]);
                $msg = 'Image added to gallery.';
            } else {
                $msg = 'Upload failed. Check folder permissions.'; $msg_type = 'danger';
            }
        }
    }
}

// ---- DELETE IMAGE ----
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
        if (file_exists('../' . $row['image_path'])) @unlink('../' . $row['image_path']);
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        $msg = 'Image removed from gallery.';
    }
}

$images = $pdo->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();

require_once 'includes/admin_header.php';
?>

<div class="admin-topbar">
  <h3 style="font-family:var(--font-heading);">Manage Gallery</h3>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="admin-card">
      <h5 class="mb-3">Add Gallery Image</h5>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="mb-3">
          <label class="form-label">Image</label>
          <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Category</label>
          <input type="text" name="category" class="form-control" placeholder="e.g. Rooms, Facilities, Events, Exterior">
        </div>
        <button type="submit" class="btn btn-gold w-100">Add to Gallery</button>
      </form>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="admin-card">
      <h5 class="mb-3">Gallery Images (<?php echo count($images); ?>)</h5>
      <div class="row g-3">
        <?php foreach ($images as $img): ?>
        <div class="col-6 col-md-4">
          <div class="position-relative">
            <img src="../<?php echo htmlspecialchars($img['image_path']); ?>" class="w-100" style="height:110px; object-fit:cover; border-radius:6px;">
            <span class="badge bg-dark position-absolute top-0 start-0 m-1" style="font-size:0.65rem;"><?php echo htmlspecialchars($img['category']); ?></span>
            <a href="?delete=<?php echo $img['id']; ?>" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" style="padding:2px 7px;"
               onclick="return confirm('Delete this image?');"><i class="bi bi-x"></i></a>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (count($images) === 0): ?>
          <p class="text-muted text-center mb-0">No gallery images uploaded yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
