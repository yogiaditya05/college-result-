<?php
require_once 'includes/header.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');
require_once 'config/db.php';
$students = $conn->query('SELECT * FROM students');
$subjects = $conn->query('SELECT * FROM subjects');
if(isset($_POST['save'])){
    $student_id = (int)$_POST['student_id'];
    $subject_id = (int)$_POST['subject_id'];
    $marks = (int)$_POST['marks'];
    $grade = trim($_POST['grade']);
    $term = trim($_POST['term']);
    $stmt = $conn->prepare('INSERT INTO results (student_id,subject_id,marks,grade,term) VALUES (?,?,?,?,?)');
    $stmt->bind_param('iiiss',$student_id,$subject_id,$marks,$grade,$term); $stmt->execute();
    header('Location: results.php'); exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Result | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Record Student Grade</h2>
          <a class="btn btn-secondary" href="results.php"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-plus-circle text-primary me-2"></i>Result Details</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Select Student</label>
                  <select name="student_id" class="form-select">
                    <?php while($s=$students->fetch_assoc()): ?>
                      <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['roll_no'].' - '.$s['name']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Select Subject</label>
                  <select name="subject_id" class="form-select">
                    <?php while($sub=$subjects->fetch_assoc()): ?>
                      <option value="<?= $sub['id'] ?>"><?= htmlspecialchars($sub['code'].' - '.$sub['title']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Marks</label>
                  <input name="marks" class="form-control" placeholder="e.g. 85" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Grade</label>
                  <input name="grade" class="form-control" placeholder="e.g. A">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Term</label>
                  <input name="term" class="form-control" value="Semester 1">
                </div>
                <button class="btn btn-primary w-100 py-2.5 mt-2" name="save">
                  <i class="bi bi-save me-1"></i> Save Grade
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
