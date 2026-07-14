<?php
require_once 'includes/header.php'; if($user['role']!='teacher') die('Unauthorized');
// get assigned classes
$stmt = $conn->prepare('SELECT DISTINCT class FROM teacher_assignments WHERE teacher_id=?');
$stmt->bind_param('i',$user['id']); $stmt->execute(); $cls_res = $stmt->get_result();
$classes = [];
while($c = $cls_res->fetch_assoc()) $classes[] = $c['class'];
if(empty($classes)) die('No classes assigned. Contact admin.');

// build safe IN list using real_escape_string
$escaped = array_map(function($v) use ($conn){ return "'" . $conn->real_escape_string($v) . "'"; }, $classes);
$in = implode(',', $escaped);

$sql = "SELECT * FROM students WHERE class IN ($in) ORDER BY roll_no";
$res = $conn->query($sql);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Students | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">My Students</h2>
          <a class="btn btn-primary" href="teacher_student_add.php"><i class="bi bi-person-plus me-2"></i>Add Student</a>
        </div>

        <div class="alert alert-secondary py-2 border-0 bg-light-subtle d-flex align-items-center">
          <i class="bi bi-building me-2 text-primary"></i>
          <span class="small fw-semibold text-muted">Assigned Classes:</span>
          <span class="ms-2 badge bg-primary"><?=esc(implode(', ',$classes))?></span>
        </div>

        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th style="width: 250px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($r = $res->fetch_assoc()): ?>
                <tr>
                  <td class="fw-semibold text-primary"><?=esc($r['roll_no'])?></td>
                  <td><strong><?=esc($r['name'])?></strong></td>
                  <td><span class="badge bg-light text-dark border"><?=esc($r['class'])?></span></td>
                  <td><span class="badge bg-secondary-subtle text-secondary"><?=esc($r['section'])?></span></td>
                  <td class="text-center">
                    <a class="btn btn-sm btn-outline-primary me-1" href="teacher_student_edit.php?id=<?=$r['id']?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a class="btn btn-sm btn-outline-danger me-1" href="teacher_student_delete.php?id=<?=$r['id']?>" onclick="return confirm('Delete student profile?')">
                      <i class="bi bi-trash"></i> Delete
                    </a>
                    <a class="btn btn-sm btn-outline-info" href="reports.php?student_id=<?=$r['id']?>">
                      <i class="bi bi-file-earmark-bar-graph"></i> Report
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