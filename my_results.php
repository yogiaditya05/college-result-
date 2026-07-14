<?php
require_once 'includes/header.php';
if($user['role']!='student') die('Unauthorized');
require_once 'config/db.php';
$stmt = $conn->prepare('SELECT s.id FROM students s WHERE s.user_id=?'); $stmt->bind_param('i',$user['id']); $stmt->execute(); $res=$stmt->get_result(); $s=$res->fetch_assoc();
if(!$s) die('No student profile found');
$student_id = $s['id'];
$q = $conn->prepare('SELECT r.*, sub.title as subject FROM results r JOIN subjects sub ON r.subject_id=sub.id WHERE r.student_id=?');
$q->bind_param('i',$student_id); $q->execute(); $res2 = $q->get_result();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Results | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">My Semester Report Card</h2>
        </div>

        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Subject</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Term</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($res2->num_rows == 0): ?>
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="bi bi-info-circle me-1"></i> No results have been posted for your profile yet.
                  </td>
                </tr>
              <?php else: ?>
                <?php while($r=$res2->fetch_assoc()): ?>
                  <tr>
                    <td><strong><?= htmlspecialchars($r['subject']) ?></strong></td>
                    <td><span class="fw-bold <?= $r['marks'] >= 40 ? 'text-success' : 'text-danger' ?>"><?= $r['marks'] ?></span></td>
                    <td>
                      <span class="badge <?= $r['marks'] >= 40 ? 'badge-pass' : 'badge-fail' ?>">
                        <?= htmlspecialchars($r['grade']) ?>
                      </span>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($r['term']) ?></span></td>
                  </tr>
                <?php endwhile; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
