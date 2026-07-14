<?php
require_once 'includes/header.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');
require_once 'config/db.php';

$err = '';
if(isset($_POST['action']) && $_POST['action']=='add_student'){
    $name = trim($_POST['name']);
    $roll = trim($_POST['roll_no']);
    $class = trim($_POST['class']);
    $section = trim($_POST['section']);
    $stmt = $conn->prepare('INSERT INTO students (roll_no,name,class,section) VALUES (?,?,?,?)');
    $stmt->bind_param('ssss',$roll,$name,$class,$section);
    $stmt->execute();
    header('Location: students.php'); exit;
}
if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM students WHERE id=?');
    $stmt->bind_param('i',$id); $stmt->execute();
    header('Location: students.php'); exit;
}

// fetch students
$res = $conn->query('SELECT * FROM students ORDER BY id DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Students | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Student Registry</h2>
          <a class="btn btn-primary" href="students_add.php"><i class="bi bi-person-plus me-2"></i>Add Student</a>
        </div>

        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width: 80px;">ID</th>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th style="width: 180px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($r = $res->fetch_assoc()): ?>
                <tr>
                  <td class="text-muted fw-medium"><?= $r['id'] ?></td>
                  <td class="fw-semibold text-primary"><?= htmlspecialchars($r['roll_no']) ?></td>
                  <td><strong><?= htmlspecialchars($r['name']) ?></strong></td>
                  <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($r['class']) ?></span></td>
                  <td><span class="badge bg-secondary-subtle text-secondary"><?= htmlspecialchars($r['section'] ?: 'N/A') ?></span></td>
                  <td class="text-center">
                    <a class="btn btn-sm btn-outline-primary me-1" href="students_edit.php?id=<?= $r['id'] ?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a class="btn btn-sm btn-outline-danger" href="students.php?delete=<?= $r['id'] ?>" onclick="return confirm('Delete student profile?')">
                      <i class="bi bi-trash"></i> Delete
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
