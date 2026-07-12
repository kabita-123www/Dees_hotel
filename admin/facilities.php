<?php
require_once 'includes/auth_check.php';
require_once '../config/db.php';
$page_title = 'Manage Facilities';

$upload_dir = '../uploads/facilities/';
$msg = ''; $msg_type = 'success';

function handle_facility_upload($upload_dir) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;
    $filename = 'facility_' . time() . '_' . uniqid() . '.' . $ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
        return 'uploads/facilities/' . $filename;
    }
    return false;
}

// ---- ADD ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image_path = handle_facility_upload($upload_dir);

    if ($image_path === false) {
        $msg = 'Image upload failed. Only JPG, PNG, WEBP allowed.'; $msg_type = 'danger';
    } elseif ($image_path === null) {
        $msg = 'Please select an image.'; $msg_type = 'danger';
    } else {
        $stmt = $pdo->prepare("INSERT INTO facilities (name, image, description) VALUES (?, ?, ?)");
        $stmt->execute([$name, $image_path, $description]);
        $msg = 'Facility added successfully.';
    }
}

// ---- EDIT ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id = (int) $_POST['id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $new_image = handle_facility_upload($upload_dir);

    if ($new_image === false) {
        $msg = 'Image upload failed.'; $msg_type = 'danger';
    } else {
        if ($new_image) {
            $stmt = $pdo->prepare("SELECT image FROM facilities WHERE id = ?");
            $stmt->execute([$id]);
            $old = $stmt->fetchColumn();
            if ($old && file_exists('../' . $old)) @unlink('../' . $old);

            $stmt = $pdo->prepare("UPDATE facilities SET name=?, description=?, image=? WHERE id=?");
            $stmt->execute([$name, $description, $new_image, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE facilities SET name=?, description=? WHERE id=?");
            $stmt->execute([$name, $description, $id]);
        }
        $msg = 'Facility updated successfully.';
    }
}

// ---- DELETE ----
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM facilities WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
        if (file_exists('../' . $row['image'])) @unlink('../' . $row['image']);
        $pdo->prepare("DELETE FROM facilities WHERE id = ?")->execute([$id]);
        $msg = 'Facility deleted.';
    }
}

$facilities = $pdo->query("SELECT * FROM facilities ORDER BY id DESC")->fetchAll();

require_once 'includes/admin_header.php';
?>

<div class="admin-topbar">
  <h3 style="font-family:var(--font-heading);">Manage Facilities</h3>
  <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addFacilityModal">
    <i class="bi bi-plus-lg"></i> Add Facility
  </button>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="admin-card">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Image</th><th>Name</th><th>Description</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($facilities as $f): ?>
        <tr>
          <td><img src="../<?php echo htmlspecialchars($f['image']); ?>" class="thumb"></td>
          <td><?php echo htmlspecialchars($f['name']); ?></td>
          <td><small><?php echo htmlspecialchars(mb_strimwidth($f['description'], 0, 60, '...')); ?></small></td>
          <td class="text-nowrap">
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#editFacilityModal<?php echo $f['id']; ?>"><i class="bi bi-pencil"></i></button>
            <a href="?delete=<?php echo $f['id']; ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Delete this facility?');"><i class="bi bi-trash"></i></a>
          </td>
        </tr>

        <div class="modal fade" id="editFacilityModal<?php echo $f['id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo $f['id']; ?>">
                <div class="modal-header"><h5 class="modal-title">Edit Facility</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                  <div class="mb-2"><label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($f['name']); ?>" required></div>
                  <div class="mb-2"><label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($f['description']); ?></textarea></div>
                  <div class="mb-2"><label class="form-label">Replace Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-gold">Save Changes</button></div>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (count($facilities) === 0): ?>
          <tr><td colspan="4" class="text-center text-muted">No facilities added yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addFacilityModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="modal-header"><h5 class="modal-title">Add New Facility</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-2"><label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Swimming Pool" required></div>
          <div class="mb-2"><label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea></div>
          <div class="mb-2"><label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp" required></div>
        </div>
        <div class="modal-footer"><button type="submit" class="btn btn-gold">Add Facility</button></div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
