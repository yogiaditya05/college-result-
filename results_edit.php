<?php
require_once 'includes/header.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');
require_once 'config/db.php';
if(!isset($_GET['id'])) die('Missing id');
$id = (int)$_GET['id'];
if(isset($_POST['save'])){
    $student_id = (int)$_POST['student_id'];
    $subject_id = (int)$_POST['subject_id'];
    $marks = (int)$_POST['marks'];
    $grade = trim($_POST['grade']);
    $term = trim($_POST['term']);
    $stmt = $conn->prepare('UPDATE results SET student_id=?,subject_id=?,marks=?,grade=?,term=? WHERE id=?');
    $stmt->bind_param('iiissi',$student_id,$subject_id,$marks,$grade,$term,$id); $stmt->execute();
    header('Location: results.php'); exit;
}
$students = $conn->query('SELECT * FROM students');
$subjects = $conn->query('SELECT * FROM subjects');
$stmt = $conn->prepare('SELECT * FROM results WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result(); $r = $res->fetch_assoc();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Result | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Modify Student Grade</h2>
          <a class="btn btn-secondary" href="results.php"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-pencil-square text-primary me-2"></i>Result Details</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Select Student</label>
                  <select name="student_id" class="form-select">
                    <?php while($s=$students->fetch_assoc()): ?>
                      <option value="<?= $s['id'] ?>" <?= $s['id']==$r['student_id']? 'selected':'' ?>><?= htmlspecialchars($s['roll_no'].' - '.$s['name']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Select Subject</label>
                  <select name="subject_id" class="form-select">
                    <?php while($sub=$subjects->fetch_assoc()): ?>
                      <option value="<?= $sub['id'] ?>" <?= $sub['id']==$r['subject_id']? 'selected':'' ?>><?= htmlspecialchars($sub['code'].' - '.$sub['title']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Marks</label>
                  <input name="marks" class="form-control" value="<?= $r['marks'] ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Grade</label>
                  <input name="grade" class="form-control" value="<?= htmlspecialchars($r['grade']) ?>">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Term</label>
                  <input name="term" class="form-control" value="<?= htmlspecialchars($r['term']) ?>">
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
