<?php
require_once 'includes/header.php';
if($user['role']!='teacher') die('Unauthorized');

// get classes
$stmt = $conn->prepare('SELECT DISTINCT class FROM teacher_assignments WHERE teacher_id=?');
$stmt->bind_param('i',$user['id']);
$stmt->execute();
$res1 = $stmt->get_result();
$classes = [];
while($c=$res1->fetch_assoc()) $classes[]=$c['class'];
if(empty($classes)) die('No classes assigned.');

// get subjects allowed
$stmt2 = $conn->prepare('SELECT DISTINCT subject_id FROM teacher_assignments WHERE teacher_id=? AND subject_id IS NOT NULL');
$stmt2->bind_param('i',$user['id']);
$stmt2->execute();
$res2 = $stmt2->get_result();
$subjects_allowed = [];
while($s=$res2->fetch_assoc()) $subjects_allowed[]=$s['subject_id'];

// build IN clause for classes
$esc = array_map(function($v) use($conn){ return "'" . $conn->real_escape_string($v) . "'"; }, $classes);
$in = implode(',', $esc);

// find students in assigned classes
$students = $conn->query("SELECT id,roll_no,name,class FROM students WHERE class IN ($in)")->fetch_all(MYSQLI_ASSOC);

// fetch only subjects assigned
if(!empty($subjects_allowed)){
    $sub_in = implode(',', array_map('intval',$subjects_allowed));
    $subjects = $conn->query("SELECT * FROM subjects WHERE id IN ($sub_in)")->fetch_all(MYSQLI_ASSOC);
} else {
    // if no subject assigned, allow none
    $subjects = [];
}

// add result
if(isset($_POST['save'])){
    $sid = intval($_POST['student_id']);
    $sub = intval($_POST['subject_id']);

    // check class
    $chk = $conn->prepare("SELECT class FROM students WHERE id=?");
    $chk->bind_param("i",$sid);
    $chk->execute();
    $sc = $chk->get_result()->fetch_assoc();

    if(!$sc || !in_array($sc['class'],$classes)) die("Unauthorized student");

    // check subject
    if(!in_array($sub,$subjects_allowed)) die("Unauthorized subject");

    $marks = intval($_POST['marks']);
    $grade = $_POST['grade'];
    $term = $_POST['term'];

    $stmt = $conn->prepare("INSERT INTO results (student_id,subject_id,marks,grade,term) VALUES (?,?,?,?,?)");
    $stmt->bind_param("iiiss",$sid,$sub,$marks,$grade,$term);
    $stmt->execute();
    header("Location: teacher_results.php"); exit;
}

// load results limited by both class and subject
$allowed_subjects_sql = empty($subjects_allowed) ? "0" : implode(',', array_map('intval',$subjects_allowed));
$results = $conn->query("
SELECT r.*, s.roll_no, s.name AS student_name, sub.title AS subject_title
FROM results r 
JOIN students s ON r.student_id=s.id
JOIN subjects sub ON r.subject_id=sub.id
WHERE s.class IN ($in) AND r.subject_id IN ($allowed_subjects_sql)
ORDER BY r.created_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Results | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Manage Results (Your Classes & Subjects)</h2>
        </div>

        <!-- Add Result Form inside Card -->
        <div class="card p-4 mb-4">
          <h5 class="card-title mb-3"><i class="bi bi-plus-circle text-primary me-2"></i>Record New Grade</h5>
          <form method="post" class="row g-3 align-items-end">
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted">Select Student</label>
              <select name="student_id" class="form-select">
                <?php foreach($students as $s): ?>
                  <option value="<?=$s['id']?>"><?=$s['roll_no']?> - <?=$s['name']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted">Select Subject</label>
              <select name="subject_id" class="form-select">
                <?php foreach($subjects as $sub): ?>
                  <option value="<?=$sub['id']?>"><?=$sub['code']?> - <?=$sub['title']?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small fw-semibold text-muted">Marks</label>
              <input name="marks" class="form-control" placeholder="Marks" required>
            </div>
            <div class="col-md-2">
              <label class="form-label small fw-semibold text-muted">Grade</label>
              <input name="grade" class="form-control" placeholder="Grade">
            </div>
            <div class="col-md-2">
              <label class="form-label small fw-semibold text-muted">Term</label>
              <input name="term" class="form-control" value="Semester 1">
            </div>
            <div class="col-12 mt-3">
              <button class="btn btn-primary w-100 py-2.5" name="save">
                <i class="bi bi-save me-1"></i> Save Grade Record
              </button>
            </div>
          </form>
        </div>

        <!-- Results List -->
        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Student</th>
                <th>Roll Number</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Term</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($results as $r): ?>
                <tr>
                  <td><strong><?=esc($r['student_name'])?></strong></td>
                  <td class="fw-semibold text-primary"><?=esc($r['roll_no'])?></td>
                  <td><?=esc($r['subject_title'])?></td>
                  <td><span class="fw-bold <?= $r['marks'] >= 40 ? 'text-success' : 'text-danger' ?>"><?=esc($r['marks'])?></span></td>
                  <td>
                    <span class="badge <?= $r['marks'] >= 40 ? 'badge-pass' : 'badge-fail' ?>">
                      <?=esc($r['grade'])?>
                    </span>
                  </td>
                  <td><span class="badge bg-light text-dark border"><?=esc($r['term'])?></span></td>
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