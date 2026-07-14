<?php
require_once 'includes/header.php';
if($user['role']!='admin') die('Unauthorized');

// Fetch live statistics
$user_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$student_count = $conn->query("SELECT COUNT(*) FROM students")->fetch_row()[0];
$assign_count = $conn->query("SELECT COUNT(*) FROM teacher_assignments")->fetch_row()[0];
$subject_count = $conn->query("SELECT COUNT(*) FROM subjects")->fetch_row()[0];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard | EduPortal</title>
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
          <h1 class="h2 page-title">Dashboard Overview</h1>
        </div>

        <!-- Welcome Banner -->
        <div class="hero-gradient mb-4">
          <h2>Welcome Back, <?=esc($user['name'])?>!</h2>
          <p>You have full access to manage roles, classes, course allocations, and student gradebooks.</p>
        </div>

        <!-- Stats Cards Grid -->
        <div class="row g-4 mb-4">
          <div class="col-md-3">
            <div class="card stat-card p-3" style="border-left-color: #4f46e5;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">System Users</h6>
                  <h3 class="mb-0 fw-bold"><?= $user_count ?></h3>
                </div>
                <div class="rounded-circle bg-light p-3 text-primary"><i class="bi bi-people-fill fs-4"></i></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card stat-card p-3" style="border-left-color: #10b981;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Students</h6>
                  <h3 class="mb-0 fw-bold"><?= $student_count ?></h3>
                </div>
                <div class="rounded-circle bg-light p-3 text-success"><i class="bi bi-mortarboard-fill fs-4"></i></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card stat-card p-3" style="border-left-color: #f59e0b;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Active Classes</h6>
                  <h3 class="mb-0 fw-bold">4</h3>
                </div>
                <div class="rounded-circle bg-light p-3 text-warning"><i class="bi bi-building fs-4"></i></div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card stat-card p-3" style="border-left-color: #3b82f6;">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Course Assignments</h6>
                  <h3 class="mb-0 fw-bold"><?= $assign_count ?></h3>
                </div>
                <div class="rounded-circle bg-light p-3 text-info"><i class="bi bi-person-badge-fill fs-4"></i></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick actions -->
        <div class="card p-4">
          <h5 class="card-title mb-3">Quick Navigation Shortcuts</h5>
          <div class="row g-2">
            <div class="col-md-3"><a class="btn btn-primary w-100 py-2.5" href="admin_manage_users.php"><i class="bi bi-person-plus me-2"></i>Manage Users</a></div>
            <div class="col-md-3"><a class="btn btn-secondary w-100 py-2.5" href="admin_assign.php"><i class="bi bi-link-45deg me-2"></i>Assign Teachers</a></div>
            <div class="col-md-3"><a class="btn btn-success w-100 py-2.5" href="students.php"><i class="bi bi-person-workspace me-2"></i>Student Profiles</a></div>
            <div class="col-md-3"><a class="btn btn-info w-100 py-2.5 text-white" href="reports.php"><i class="bi bi-file-earmark-bar-graph me-2"></i>Academic Reports</a></div>
          </div>
        </div>

      </main>
    </div>
  </div>
</body>
</html>