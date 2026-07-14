<?php require_once 'includes/header.php'; if($user['role']!='admin') die('Unauthorized');
if(isset($_GET['delete'])){ $id=intval($_GET['delete']); $stmt=$conn->prepare('DELETE FROM users WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); header('Location: admin_manage_users.php'); exit; }
$users = $conn->query('SELECT id,name,email,role,created_at FROM users ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Users | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Manage Users & Roles</h2>
          <a class="btn btn-primary" href="admin_user_add.php"><i class="bi bi-person-plus me-2"></i>Add User</a>
        </div>

        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width: 80px;">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width: 180px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($users as $u): ?>
                <tr>
                  <td class="text-muted fw-medium"><?=esc($u['id'])?></td>
                  <td><strong><?=esc($u['name'])?></strong></td>
                  <td><?=esc($u['email'])?></td>
                  <td>
                    <?php 
                      $role_class = 'badge-role-student';
                      if($u['role']=='admin') $role_class = 'badge-role-admin';
                      elseif($u['role']=='teacher') $role_class = 'badge-role-teacher';
                    ?>
                    <span class="badge <?= $role_class ?> text-capitalize"><?=esc($u['role'])?></span>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-sm btn-outline-primary me-1" href="admin_user_edit.php?id=<?=$u['id']?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <?php if($u['id']!=$user['id']): ?>
                      <a class="btn btn-sm btn-outline-danger" href="?delete=<?=$u['id']?>" onclick="return confirm('Delete user?')">
                        <i class="bi bi-trash"></i> Delete
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</html>