<?php
require_once 'includes/header.php';
require_once 'config/db.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');

$class = $_GET['class'] ?? '';
$student_id = (int)($_GET['student_id'] ?? 0);

$where = [];
if($class) $where[] = "s.class='". $conn->real_escape_string($class) ."'";
if($student_id) $where[] = "r.student_id=".$student_id;
$sql = "SELECT r.*, s.name as student_name, s.roll_no, sub.title as subject_title FROM results r JOIN students s ON r.student_id=s.id JOIN subjects sub ON r.subject_id=sub.id";
if($where) $sql .= " WHERE ".implode(' AND ',$where);
$sql .= " ORDER BY r.id DESC";

$res = $conn->query($sql);

// CSV export
if(isset($_GET['export']) && $_GET['export']=='csv'){
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="results_report.csv"');
    $out = fopen('php://output','w');
    fputcsv($out, ['ID','Roll','Student','Subject','Marks','Grade','Term','Date']);
    while($r = $res->fetch_assoc()){
        fputcsv($out, [$r['id'],$r['roll_no'],$r['student_name'],$r['subject_title'],$r['marks'],$r['grade'],$r['term'],$r['created_at']]);
    }
    exit;
}
$students = $conn->query('SELECT * FROM students');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reports | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Academic Performance Reports</h2>
        </div>

        <!-- Filter Form in Card -->
        <div class="card p-3 mb-4">
          <form class="row g-3 align-items-center">
            <div class="col-auto" style="min-width: 250px;">
              <select name="student_id" class="form-select">
                <option value="">-- Select Student --</option>
                <?php while($s=$students->fetch_assoc()): ?>
                  <option value="<?= $s['id'] ?>" <?= $s['id']==$student_id? 'selected':'' ?>><?= htmlspecialchars($s['roll_no'].' - '.$s['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-auto">
              <input class="form-control" name="class" placeholder="Class" value="<?= htmlspecialchars($class) ?>">
            </div>
            <div class="col-auto">
              <button class="btn btn-primary"><i class="bi bi-filter me-1"></i> Filter</button>
            </div>
            <div class="col-auto">
              <a class="btn btn-success" href="?export=csv<?= $class? '&class='.urlencode($class):'' ?><?= $student_id? '&student_id='.$student_id: '' ?>">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV
              </a>
            </div>
          </form>
        </div>

        <!-- Reports Table -->
        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width: 80px;">ID</th>
                <th>Roll No</th>
                <th>Student</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Term</th>
              </tr>
            </thead>
            <tbody>
              <?php while($r = $res->fetch_assoc()): ?>
                <tr>
                  <td class="text-muted fw-medium"><?= $r['id'] ?></td>
                  <td class="fw-semibold text-primary"><?= htmlspecialchars($r['roll_no']) ?></td>
                  <td><strong><?= htmlspecialchars($r['student_name']) ?></strong></td>
                  <td><?= htmlspecialchars($r['subject_title']) ?></td>
                  <td><span class="fw-bold <?= $r['marks'] >= 40 ? 'text-success' : 'text-danger' ?>"><?= $r['marks'] ?></span></td>
                  <td>
                    <span class="badge <?= $r['marks'] >= 40 ? 'badge-pass' : 'badge-fail' ?>">
                      <?= htmlspecialchars($r['grade']) ?>
                    </span>
                  </td>
                  <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($r['term']) ?></span></td>
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
