<?php
require_once 'includes/header.php';
if($user['role']!='student') die('Unauthorized');
require_once 'config/db.php';
$stmt = $conn->prepare('SELECT s.* FROM students s WHERE s.user_id=?'); $stmt->bind_param('i',$user['id']); $stmt->execute(); $res=$stmt->get_result();
$s = $res->fetch_assoc();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Dashboard | EduPortal</title>
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
          <h1 class="h2 page-title">Student Dashboard</h1>
        </div>

        <!-- Welcome Banner -->
        <div class="hero-gradient mb-4">
          <h2>Welcome, <?=esc($user['name'])?>!</h2>
          <p>View your term results, marks, grades, and academic achievements here.</p>
        </div>

        <!-- Profile Details Card -->
        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-person-badge text-primary me-2"></i>My Student Profile</h5>
              <?php if($s): ?>
                <div class="d-flex align-items-center gap-3 mb-4">
                  <div class="rounded-circle bg-primary-subtle text-primary p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-fill fs-2"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold mb-0"><?= esc($s['name']) ?></h5>
                    <p class="text-muted mb-0"><?= esc($user['email']) ?></p>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-sm table-borderless">
                    <tr>
                      <td class="text-muted fw-semibold ps-0 py-2" style="width: 120px;">Roll Number</td>
                      <td class="py-2 text-dark"><?= esc($s['roll_no']) ?></td>
                    </tr>
                    <tr>
                      <td class="text-muted fw-semibold ps-0 py-2">Current Class</td>
                      <td class="py-2 text-dark"><?= esc($s['class']) ?></td>
                    </tr>
                    <tr>
                      <td class="text-muted fw-semibold ps-0 py-2">Section</td>
                      <td class="py-2 text-dark"><?= esc($s['section']) ?></td>
                    </tr>
                  </table>
                </div>
                <div class="mt-3">
                  <a class="btn btn-primary w-100 py-2.5" href="my_results.php">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>View My Results
                  </a>
                </div>
              <?php else: ?>
                <div class="alert alert-warning d-flex align-items-center mb-0" role="alert">
                  <i class="bi bi-exclamation-triangle-fill me-2"></i>
                  <div>No student profile linked to your user account. Please contact the administrator.</div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>
</body>
</html>
