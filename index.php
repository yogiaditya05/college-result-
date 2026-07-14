<?php
session_start();
require_once 'config/db.php';
$err='';
if(isset($_POST['login'])){
    $email = $_POST['email']; $pass = $_POST['password'];
    $stmt = $conn->prepare('SELECT id,name,email,password,role FROM users WHERE email=?');
    $stmt->bind_param('s',$email); $stmt->execute(); $res = $stmt->get_result();
    if($res && $res->num_rows==1){
        $u = $res->fetch_assoc();
        if(password_verify($pass, $u['password'])){
            $_SESSION['user'] = $u;
            if($u['role']=='admin') header('Location: admin_dashboard.php');
            elseif($u['role']=='teacher') header('Location: teacher_dashboard.php');
            else header('Location: student_dashboard.php');
            exit;
        }
    }
    $err = 'Invalid credentials';
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login | College Result Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-card">
    <div class="login-card-header">
      <i class="bi bi-mortarboard-fill" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
      <h3 class="mb-1" style="font-weight: 700; letter-spacing: 0.5px;">EduPortal</h3>
      <p class="mb-0 text-white-50" style="font-size: 0.9rem;">College Result Management System</p>
    </div>
    <div class="login-card-body">
      <?php if($err): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <div><?=esc($err)?></div>
        </div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted);">Email Address</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
            <input name="email" required class="form-control border-start-0 ps-0" type="email" placeholder="name@college.com">
          </div>
        </div>
        <div class="mb-4">
          <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted);">Password</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
            <input name="password" required class="form-control border-start-0 ps-0" type="password" placeholder="••••••••">
          </div>
        </div>
        <button class="btn btn-primary w-100 py-2.5" name="login" style="font-weight: 600; font-size: 0.95rem;">
          Sign In
        </button>
      </form>
    </div>
  </div>
</body>
</html>