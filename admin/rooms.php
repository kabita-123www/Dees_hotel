<?php
require_once 'includes/auth_check.php';
require_once '../config/db.php';
$page_title = 'Manage Rooms';

$upload_dir = '../uploads/rooms/';
$msg = ''; $msg_type = 'success';

function handle_room_upload($upload_dir) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return false;
    $filename = 'room_' . time() . '_' . uniqid() . '.' . $ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
        return 'uploads/rooms/' . $filename;
    }
    return false;
}

// ---- ADD ROOM ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $type = trim($_POST['type']);
    $description = trim($_POST['description']);
    $price = (float) $_POST['price'];
    $features = trim($_POST['features']);
    $image_path = handle_room_upload($upload_dir);

    if ($image_path === false) {
        $msg = 'Image upload failed. Only JPG, PNG, WEBP allowed.'; $msg_type = 'danger';
    } elseif ($image_path === null) {
        $msg = 'Please select an image for the room.'; $msg_type = 'danger';
    } else {
        $stmt = $pdo->prepare("INSERT INTO rooms (type, description, price, image, features) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$type, $description, $price, $image_path, $features]);
        $msg = 'Room added successfully.';
    }
}

// ---- UPDATE ROOM ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id = (int) $_POST['id'];
    $type = trim($_POST['type']);
    $description = trim($_POST['description']);
    $price = (float) $_POST['price'];
    $features = trim($_POST['features']);

    $new_image = handle_room_upload($upload_dir);
    if ($new_image === false) {
        $msg = 'Image upload failed.'; $msg_type = 'danger';
    } else {
        if ($new_image) {
            // remove old image
            $stmt = $pdo->prepare("SELECT image FROM rooms WHERE id = ?");
            $stmt->execute([$id]);
            $old = $stmt->fetchColumn();
            if ($old && file_exists('../' . $old)) @unlink('../' . $old);

            $stmt = $pdo->prepare("UPDATE rooms SET type=?, description=?, price=?, features=?, image=? WHERE id=?");
            $stmt->execute([$type, $description, $price, $features, $new_image, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE rooms SET type=?, description=?, price=?, features=? WHERE id=?");
            $stmt->execute([$type, $description, $price, $features, $id]);
        }
        $msg = 'Room updated successfully.';
    }
}

// ---- DELETE ROOM ----
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM rooms WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
        if (file_exists('../' . $row['image'])) @unlink('../' . $row['image']);
        $pdo->prepare("DELETE FROM rooms WHERE id = ?")->execute([$id]);
        $msg = 'Room deleted.';
    }
}

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY id DESC")->fetchAll();

require_once 'includes/admin_header.php';
?>

<div class="admin-topbar">
  <h3 style="font-family:var(--font-heading);">Manage Rooms</h3>
  <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addRoomModal">
    <i class="bi bi-plus-lg"></i> Add Room
  </button>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="admin-card">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Image</th><th>Type</th><th>Price</th><th>Features</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($rooms as $r): ?>
        <tr>
          <td><img src="../<?php echo htmlspecialchars($r['image']); ?>" class="thumb"></td>
          <td><?php echo htmlspecialchars($r['type']); ?></td>
          <td>NPR <?php echo number_format($r['price'], 0); ?></td>
          <td><small><?php echo htmlspecialchars(mb_strimwidth($r['features'], 0, 50, '...')); ?></small></td>
          <td class="text-nowrap">
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#editRoomModal<?php echo $r['id']; ?>"><i class="bi bi-pencil"></i></button>
            <a href="?delete=<?php echo $r['id']; ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Delete this room?');"><i class="bi bi-trash"></i></a>
          </td>
        </tr>

        <!-- Edit Modal -->
        <div class="modal fade" id="editRoomModal<?php echo $r['id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                <div class="modal-header"><h5 class="modal-title">Edit Room</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-2"><label class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" value="<?php echo htmlspecialchars($r['type']); ?>" required></div>
                  <div class="mb-2"><label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($r['description']); ?></textarea></div>
                  <div class="mb-2"><label class="form-label">Price (NPR)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $r['price']; ?>" required></div>
                  <div class="mb-2"><label class="form-label">Features (comma-separated)</label>
                    <input type="text" name="features" class="form-control" value="<?php echo htmlspecialchars($r['features']); ?>"></div>
                  <div class="mb-2"><label class="form-label">Replace Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-gold">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (count($rooms) === 0): ?>
          <tr><td colspan="5" class="text-center text-muted">No rooms added yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="modal-header"><h5 class="modal-title">Add New Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2"><label class="form-label">Type</label>
            <input type="text" name="type" class="form-control" placeholder="e.g. Deluxe Room" required></div>
          <div class="mb-2"><label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea></div>
          <div class="mb-2"><label class="form-label">Price (NPR)</label>
            <input type="number" step="0.01" name="price" class="form-control" required></div>
          <div class="mb-2"><label class="form-label">Features (comma-separated)</label>
            <input type="text" name="features" class="form-control" placeholder="Free WiFi, AC, Breakfast Included"></div>
          <div class="mb-2"><label class="form-label">Room Image</label>
            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp" required></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-gold">Add Room</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
