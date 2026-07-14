<?php
require_once 'includes/header.php';
if($user['role']!='teacher') die('Unauthorized');

// Get assigned classes
$stmt_cls = $conn->prepare('SELECT DISTINCT class FROM teacher_assignments WHERE teacher_id=?');
$stmt_cls->bind_param('i', $user['id']);
$stmt_cls->execute();
$cls_res = $stmt_cls->get_result();
$classes = [];
while($c = $cls_res->fetch_assoc()) $classes[] = $c['class'];

$student_count = 0;
if(!empty($classes)) {
    $esc = array_map(function($v) use ($conn){ return "'" . $conn->real_escape_string($v) . "'"; }, $classes);
    $in = implode(',', $esc);
    $student_count = $conn->query("SELECT COUNT(*) FROM students WHERE class IN ($in)")->fetch_row()[0];
}

$assign_stmt = $conn->prepare('SELECT ta.class, sub.code, sub.title FROM teacher_assignments ta LEFT JOIN subjects sub ON ta.subject_id=sub.id WHERE ta.teacher_id=?');
$assign_stmt->bind_param('i', $user['id']);
$assign_stmt->execute();
$assignments = $assign_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teacher Dashboard | EduPortal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php include 'includes/sidebar.php'; ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 page-title">Teacher Dashboard</h1>
        </div>

        <!-- Welcome Banner -->
        <div class="hero-gradient mb-4">
          <h2>Welcome, <?=esc($user['name'])?>!</h2>
          <p>You can record grades, view your students, and manage course result sheets.</p>
        </div>

        <!-- Stats Overview -->
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="card stat-card p-3" style="border-left-color: #4f46e5;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">My Students</h6>
                  <h3 class="mb-0 fw-bold"><?= $student_count ?></h3>
                </div>
                <div class="rounded-circle bg-light p-3 text-primary"><i class="bi bi-people-fill fs-4"></i></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card stat-card p-3" style="border-left-color: #10b981;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Assigned Courses</h6>
                  <h3 class="mb-0 fw-bold"><?= count($assignments) ?></h3>
                </div>
                <div class="rounded-circle bg-light p-3 text-success"><i class="bi bi-journal-bookmark-fill fs-4"></i></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Course Assignments List -->
        <h5 class="mb-3" style="font-weight: 600;">My Classes & Subjects</h5>
        <div class="row g-3">
          <?php if (empty($assignments)): ?>
            <div class="col-12">
              <div class="alert alert-info">No classes or subjects currently assigned to you.</div>
            </div>
          <?php else: ?>
            <?php foreach ($assignments as $row): ?>
              <div class="col-md-4">
                <div class="card p-3 h-100">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary-subtle text-primary" style="font-size: 0.8rem;"><?=esc($row['class'])?></span>
                    <i class="bi bi-book text-muted fs-5"></i>
                  </div>
                  <h6 class="fw-bold mb-1"><?= $row['title']? esc($row['title']) : 'General Classroom' ?></h6>
                  <p class="text-muted small mb-0"><?= $row['code']? esc($row['code']) : 'No Subject Code' ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      </main>
    </div>
  </div>
</body>
</html>