<?php require_once 'includes/header.php'; if($user['role']!='admin') die('Unauthorized');
$id = isset($_GET['id'])?intval($_GET['id']):0; if(!$id) header('Location: admin_manage_users.php'); $err=''; if(isset($_POST['save'])){ $name=$_POST['name']; $email=$_POST['email']; $role=$_POST['role']; if(!empty($_POST['password'])){ $hash=password_hash($_POST['password'], PASSWORD_DEFAULT); $stmt=$conn->prepare('UPDATE users SET name=?,email=?,role=?,password=? WHERE id=?'); $stmt->bind_param('ssssi',$name,$email,$role,$hash,$id); } else{ $stmt=$conn->prepare('UPDATE users SET name=?,email=?,role=? WHERE id=?'); $stmt->bind_param('sssi',$name,$email,$role,$id); } if($stmt->execute()) header('Location: admin_manage_users.php'); else $err='Error: '.$conn->error; }
$stmt=$conn->prepare('SELECT * FROM users WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $u=$stmt->get_result()->fetch_assoc();
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit User | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Modify User Accounts</h2>
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
              <h5 class="card-title mb-4"><i class="bi bi-pencil-square text-primary me-2"></i>Edit User Info</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Full Name</label>
                  <input name="name" value="<?=esc($u['name'])?>" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Email Address</label>
                  <input name="email" value="<?=esc($u['email'])?>" class="form-control" type="email" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">System Role</label>
                  <select name="role" class="form-select">
                    <option value="admin" <?=($u['role']=='admin')?'selected':''?>>Admin</option>
                    <option value="teacher" <?=($u['role']=='teacher')?'selected':''?>>Teacher</option>
                    <option value="student" <?=($u['role']=='student')?'selected':''?>>Student</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Password</label>
                  <input name="password" class="form-control" placeholder="Leave blank to keep current password">
                </div>
                <button class="btn btn-primary w-100 py-2.5 mt-2" name="save">
                  <i class="bi bi-check-circle me-1"></i> Update User Account
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