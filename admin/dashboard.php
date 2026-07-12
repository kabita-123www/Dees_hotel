<?php
require_once 'includes/auth_check.php';
require_once '../config/db.php';
$page_title = 'Dashboard';

$counts = [
    'rooms'      => $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn(),
    'facilities' => $pdo->query("SELECT COUNT(*) FROM facilities")->fetchColumn(),
    'gallery'    => $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn(),
    'slideshow'  => $pdo->query("SELECT COUNT(*) FROM slideshow")->fetchColumn(),
    'messages'   => $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn(),
    'unread'     => $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0")->fetchColumn(),
];

$recent_messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5")->fetchAll();

require_once 'includes/admin_header.php';
?>

<div class="admin-topbar">
  <div>
    <h3 class="mb-0" style="font-family:var(--font-heading);">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h3>
    <small style="color:var(--color-text-muted);">Here's what's happening at Dees Boutique Hotel today.</small>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-2 col-6">
    <div class="stat-card">
      <div style="font-size:1.6rem; color:var(--color-copper);"><?php echo $counts['rooms']; ?></div>
      <small>Rooms</small>
    </div>
  </div>
  <div class="col-md-2 col-6">
    <div class="stat-card">
      <div style="font-size:1.6rem; color:var(--color-copper);"><?php echo $counts['facilities']; ?></div>
      <small>Facilities</small>
    </div>
  </div>
  <div class="col-md-2 col-6">
    <div class="stat-card">
      <div style="font-size:1.6rem; color:var(--color-copper);"><?php echo $counts['gallery']; ?></div>
      <small>Gallery Images</small>
    </div>
  </div>
  <div class="col-md-2 col-6">
    <div class="stat-card">
      <div style="font-size:1.6rem; color:var(--color-copper);"><?php echo $counts['slideshow']; ?></div>
      <small>Slides</small>
    </div>
  </div>
  <div class="col-md-2 col-6">
    <div class="stat-card">
      <div style="font-size:1.6rem; color:var(--color-copper);"><?php echo $counts['messages']; ?></div>
      <small>Total Messages</small>
    </div>
  </div>
  <div class="col-md-2 col-6">
    <div class="stat-card" style="border-left-color:#b03535;">
      <div style="font-size:1.6rem; color:#b03535;"><?php echo $counts['unread']; ?></div>
      <small>Unread Messages</small>
    </div>
  </div>
</div>

<div class="admin-card">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Recent Contact Messages</h5>
    <a href="messages.php" class="btn btn-sm btn-outline-secondary">View All &amp; Manage</a>
  </div>
  <?php if (count($recent_messages) === 0): ?>
    <p class="text-muted mb-0">No messages received yet.</p>
  <?php else: ?>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Received</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($recent_messages as $m): ?>
        <tr>
          <td><?php echo htmlspecialchars($m['name']); ?></td>
          <td><?php echo htmlspecialchars($m['email']); ?></td>
          <td><?php echo htmlspecialchars($m['subject'] ?: '—'); ?></td>
          <td><?php echo date('M d, Y', strtotime($m['created_at'])); ?></td>
          <td class="text-nowrap">
            <a href="messages.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
            <a href="messages.php?delete=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Delete this message?');"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once 'includes/admin_footer.php'; ?>