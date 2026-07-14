<?php
require_once 'includes/header.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');
require_once 'config/db.php';
if(!isset($_GET['id'])) die('Missing id');
$id = (int)$_GET['id'];
if(isset($_POST['save'])){
    $name = trim($_POST['name']);
    $roll = trim($_POST['roll_no']);
    $class = trim($_POST['class']);
    $section = trim($_POST['section']);
    $stmt = $conn->prepare('UPDATE students SET roll_no=?,name=?,class=?,section=? WHERE id=?');
    $stmt->bind_param('ssssi',$roll,$name,$class,$section,$id); $stmt->execute();
    header('Location: students.php'); exit;
}
$stmt = $conn->prepare('SELECT * FROM students WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result();
$s = $res->fetch_assoc();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Student | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Edit Student Profile</h2>
          <a class="btn btn-secondary" href="students.php"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-pencil-square text-primary me-2"></i>Student Details</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Roll Number</label>
                  <input name="roll_no" class="form-control" value="<?= htmlspecialchars($s['roll_no']) ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Full Name</label>
                  <input name="name" class="form-control" value="<?= htmlspecialchars($s['name']) ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Class</label>
                  <input name="class" class="form-control" value="<?= htmlspecialchars($s['class']) ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Section</label>
                  <input name="section" class="form-control" value="<?= htmlspecialchars($s['section']) ?>">
                </div>
                <button class="btn btn-primary w-100 py-2.5 mt-2" name="save">
                  <i class="bi bi-save me-1"></i> Save Changes
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
