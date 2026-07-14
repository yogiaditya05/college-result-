<?php require_once 'includes/header.php'; if($user['role']!='admin') die('Unauthorized');
$err=''; if(isset($_POST['save'])){ $name=$_POST['name']; $email=$_POST['email']; $role=$_POST['role']; $pass=$_POST['password']; $hash=password_hash($pass, PASSWORD_DEFAULT); $stmt=$conn->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)'); $stmt->bind_param('ssss',$name,$email,$hash,$role); if($stmt->execute()) header('Location: admin_manage_users.php'); else $err='Error: '.$conn->error; }
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add User | EduPortal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php include 'includes/sidebar.php'; ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2 class="h2 page-title mb-0">Create System User</h2>
          <a class="btn btn-secondary" href="admin_manage_users.php"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <?php if($err): ?>
          <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div><?=esc($err)?></div>
          </div>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-person-plus text-primary me-2"></i>User Credentials</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Full Name</label>
                  <input name="name" class="form-control" placeholder="e.g. John Doe" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Email Address</label>
                  <input name="email" class="form-control" placeholder="e.g. john@college.com" type="email" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">System Role</label>
                  <select name="role" class="form-select">
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Account Password</label>
                  <input name="password" class="form-control" placeholder="Password" required>
                </div>
                <button class="btn btn-primary w-100 py-2.5 mt-2" name="save">
                  <i class="bi bi-person-check me-1"></i> Create User
                </button>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>