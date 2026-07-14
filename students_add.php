<?php
require_once 'includes/header.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');
require_once 'config/db.php';
if(isset($_POST['save'])){
    $name = trim($_POST['name']);
    $roll = trim($_POST['roll_no']);
    $class = trim($_POST['class']);
    $section = trim($_POST['section']);
    $stmt = $conn->prepare('INSERT INTO students (roll_no,name,class,section) VALUES (?,?,?,?)');
    $stmt->bind_param('ssss',$roll,$name,$class,$section); $stmt->execute();
    header('Location: students.php'); exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Student | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Add Student Profile</h2>
          <a class="btn btn-secondary" href="students.php"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-person-plus text-primary me-2"></i>Student Details</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Roll Number</label>
                  <input name="roll_no" class="form-control" placeholder="e.g. 0827CS251000" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Full Name</label>
                  <input name="name" class="form-control" placeholder="e.g. Rahul Mehta" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Class</label>
                  <input name="class" class="form-control" placeholder="e.g. B.Tech CSE">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Section</label>
                  <input name="section" class="form-control" placeholder="e.g. A">
                </div>
                <button class="btn btn-primary w-100 py-2.5 mt-2" name="save">
                  <i class="bi bi-save me-1"></i> Save Profile
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
