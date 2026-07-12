<?php
require_once 'includes/auth_check.php';
require_once '../config/db.php';
$page_title = 'Contact Messages';

$msg = ''; $msg_type = 'success';

// ---- DELETE MESSAGE ----
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM messages WHERE id = ?")->execute([$id]);
    $msg = 'Message deleted.';
}

// ---- MARK AS READ (when opened via modal) ----
if (isset($_GET['read'])) {
    $id = (int) $_GET['read'];
    $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?")->execute([$id]);
    header('Location: messages.php');
    exit;
}

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();

require_once 'includes/admin_header.php';
?>

<div class="admin-topbar">
  <h3 style="font-family:var(--font-heading);">Contact Messages</h3>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="admin-card">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Subject</th>
          <th>Received</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $m): ?>
        <tr style="<?php echo $m['is_read'] ? '' : 'font-weight:600; background:#fff9ec;'; ?>">
          <td>
            <?php if (!$m['is_read']): ?>
              <span class="badge" style="background:var(--color-copper);">New</span>
            <?php endif; ?>
          </td>
          <td><?php echo htmlspecialchars($m['name']); ?></td>
          <td><?php echo htmlspecialchars($m['email']); ?></td>
          <td><?php echo htmlspecialchars($m['phone'] ?: '—'); ?></td>
          <td><?php echo htmlspecialchars($m['subject'] ?: '—'); ?></td>
          <td><?php echo date('M d, Y g:i A', strtotime($m['created_at'])); ?></td>
          <td class="text-nowrap">
            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#viewMsg<?php echo $m['id']; ?>"><i class="bi bi-eye"></i></button>
            <a href="?delete=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Delete this message? This cannot be undone.');"><i class="bi bi-trash"></i></a>
          </td>
        </tr>

        <!-- View Modal -->
        <div class="modal fade" id="viewMsg<?php echo $m['id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo htmlspecialchars($m['subject'] ?: 'Message from ' . $m['name']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($m['name']); ?></p>
                <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($m['email']); ?></p>
                <p class="mb-1"><strong>Phone:</strong> <?php echo htmlspecialchars($m['phone'] ?: '—'); ?></p>
                <p class="mb-3"><strong>Received:</strong> <?php echo date('M d, Y g:i A', strtotime($m['created_at'])); ?></p>
                <hr>
                <p style="white-space: pre-wrap;"><?php echo htmlspecialchars($m['message']); ?></p>
              </div>
              <div class="modal-footer">
                <a href="mailto:<?php echo htmlspecialchars($m['email']); ?>" class="btn btn-gold btn-sm">
                  <i class="bi bi-reply"></i> Reply by Email
                </a>
                <?php if (!$m['is_read']): ?>
                  <a href="?read=<?php echo $m['id']; ?>" class="btn btn-outline-secondary btn-sm">Mark as Read</a>
                <?php endif; ?>
                <a href="?delete=<?php echo $m['id']; ?>" class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Delete this message?');">Delete</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

        <?php if (count($messages) === 0): ?>
          <tr><td colspan="7" class="text-center text-muted">No messages received yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once 'includes/admin_footer.php'; ?>
