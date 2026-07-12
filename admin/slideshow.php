<?php
require_once 'includes/auth_check.php';
require_once '../config/db.php';
$page_title = 'Manage Slideshow';

$upload_dir = '../uploads/slideshow/';
$msg = ''; $msg_type = 'success';

// ---- ADD SLIDE ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $caption = trim($_POST['caption'] ?? '');

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $msg = 'Please choose an image to upload.'; $msg_type = 'danger';
    } else {
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $msg = 'Only JPG, PNG, and WEBP images are allowed.'; $msg_type = 'danger';
        } else {
            $filename = 'slide_' . time() . '_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
                $stmt = $pdo->prepare("INSERT INTO slideshow (image_path, caption) VALUES (?, ?)");
                $stmt->execute(['uploads/slideshow/' . $filename, $caption]);
                $msg = 'Slide added successfully.';
            } else {
                $msg = 'Failed to upload image. Check folder permissions.'; $msg_type = 'danger';
            }
        }
    }
}

// ---- DELETE SLIDE ----
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_path FROM slideshow WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
        $filePath = '../' . $row['image_path'];
        if (file_exists($filePath)) @unlink($filePath);
        $pdo->prepare("DELETE FROM slideshow WHERE id = ?")->execute([$id]);
        $msg = 'Slide deleted.';
    }
}

$slides = $pdo->query("SELECT * FROM slideshow ORDER BY id DESC")->fetchAll();

require_once 'includes/admin_header.php';
?>

<div class="admin-topbar">
  <h3 style="font-family:var(--font-heading);">Manage Slideshow</h3>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="admin-card">
      <h5 class="mb-3">Upload New Slide</h5>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="mb-3">
          <label class="form-label">Image</label>
          <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
          <small class="text-muted">Recommended size: 1920x1080px</small>
        </div>
        <div class="mb-3">
          <label class="form-label">Caption (optional)</label>
          <input type="text" name="caption" class="form-control" placeholder="e.g. Welcome to Dees Boutique Hotel">
        </div>
        <button type="submit" class="btn btn-gold w-100">Upload Slide</button>
      </form>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="admin-card">
      <h5 class="mb-3">Current Slides (<?php echo count($slides); ?>)</h5>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>Image</th><th>Caption</th><th>Added</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($slides as $s): ?>
            <tr>
              <td><img src="../<?php echo htmlspecialchars($s['image_path']); ?>" class="thumb"></td>
              <td><?php echo htmlspecialchars($s['caption'] ?: '—'); ?></td>
              <td><?php echo date('M d, Y', strtotime($s['created_at'])); ?></td>
              <td>
                <a href="?delete=<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Delete this slide?');"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (count($slides) === 0): ?>
              <tr><td colspan="4" class="text-center text-muted">No slides uploaded yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
