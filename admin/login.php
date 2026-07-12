<?php
session_start();
require_once '../config/db.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']       = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['last_activity']  = time();
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Dees Boutique Hotel</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Great+Vibes&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../css/style.css">
<style>
  body {
    min-height: 100vh; display:flex; align-items:center; justify-content:center;
    background: var(--gradient-dark);
    background-image:
      radial-gradient(circle at 20% 20%, rgba(212,175,55,0.08) 0%, transparent 40%),
      radial-gradient(circle at 80% 80%, rgba(184,115,51,0.10) 0%, transparent 45%),
      var(--gradient-dark);
  }
  .login-box {
    background: #fff;
    border-radius: 12px;
    padding: 48px 42px;
    max-width: 410px;
    width: 100%;
    box-shadow: 0 25px 70px rgba(0,0,0,0.45);
    border-top: 3px solid;
    border-image: var(--gradient-copper-gold) 1;
  }
  .login-box .brand {
    font-family: var(--font-script);
    font-size: 2.3rem;
    color: var(--color-copper);
    text-align: center;
    display: block;
    line-height: 1.1;
  }
  .login-box .subtitle {
  color: #4a2d03;   /* lighter tone than the default muted color */
  font-size: 0.78rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 32px;
}
  .login-box .form-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--color-brown);
    letter-spacing: 0.3px;
  }
  .login-box .input-group-text {
    background: var(--color-cream-2);
    border: 1px solid rgba(184,115,51,0.25);
    color: var(--color-copper);
  }
  .login-box .form-control {
    background: var(--color-cream-2);
    border: 1px solid rgba(184,115,51,0.25);
    padding: 11px 14px;
  }
  .login-box .form-control:focus {
    border-color: var(--color-gold);
    box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.18);
    background: #fff;
  }
  .login-box .input-group:focus-within .input-group-text {
    border-color: var(--color-gold);
  }
  .toggle-password {
    cursor: pointer;
    user-select: none;
  }
  .toggle-password:hover { color: var(--color-gold) !important; }
  .login-box .btn-gold {
    padding: 13px;
    font-size: 0.9rem;
    letter-spacing: 1.5px;
  }
</style>
</head>
<body>
  <div class="login-box">
    <span class="brand">Dees Admin</span>
    <div class="subtitle">Boutique Hotel Dashboard</div>

    <?php if (isset($_GET['timeout'])): ?>
      <div class="alert alert-warning py-2 small">Your session expired. Please log in again.</div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="form-luxury" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="username" class="form-control" required autofocus 
                 placeholder="Enter your username">
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" id="passwordField" class="form-control" required
                 placeholder="Enter your password">
          <span class="input-group-text toggle-password" id="togglePassword">
            <i class="bi bi-eye-slash" id="toggleIcon"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-gold w-100">Log In</button>
    </form>
    <p class="text-center mt-4 mb-0"><a href="../index.php" style="color:var(--color-copper); font-size:1.85rem;"><i class="bi bi-arrow-left"></i> Back to Website</a></p>
  </div>

  <script>
    const toggleBtn = document.getElementById('togglePassword');
    const passwordField = document.getElementById('passwordField');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleBtn.addEventListener('click', function () {
      const isPassword = passwordField.type === 'password';
      passwordField.type = isPassword ? 'text' : 'password';
      toggleIcon.classList.toggle('bi-eye');
      toggleIcon.classList.toggle('bi-eye-slash');
    });
  </script>
</body>
</html>