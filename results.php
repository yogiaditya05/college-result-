<?php
require_once 'includes/header.php';
if($user['role']!='admin' && $user['role']!='teacher') die('Unauthorized');
require_once 'config/db.php';

if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM results WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute();
    header('Location: results.php'); exit;
}

$res = $conn->query('SELECT r.*, s.name as student_name, sub.title as subject_title FROM results r LEFT JOIN students s ON r.student_id=s.id LEFT JOIN subjects sub ON r.subject_id=sub.id ORDER BY r.id DESC');
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
          <h2 class="h2 page-title mb-0">Gradebook Registry</h2>
          <a class="btn btn-primary" href="results_add.php"><i class="bi bi-plus-circle me-2"></i>Add Result</a>
        </div>

        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width: 80px;">ID</th>
                <th>Student</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Term</th>
                <th style="width: 180px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($r = $res->fetch_assoc()): ?>
                <tr>
                  <td class="text-muted fw-medium"><?= $r['id'] ?></td>
                  <td><strong><?= htmlspecialchars($r['student_name']) ?></strong></td>
                  <td><?= htmlspecialchars($r['subject_title']) ?></td>
                  <td><span class="fw-bold <?= $r['marks'] >= 40 ? 'text-success' : 'text-danger' ?>"><?= $r['marks'] ?></span></td>
                  <td>
                    <span class="badge <?= $r['marks'] >= 40 ? 'badge-pass' : 'badge-fail' ?>">
                      <?= htmlspecialchars($r['grade']) ?>
                    </span>
                  </td>
                  <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($r['term']) ?></span></td>
                  <td class="text-center">
                    <a class="btn btn-sm btn-outline-primary me-1" href="results_edit.php?id=<?= $r['id'] ?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a class="btn btn-sm btn-outline-danger" href="results.php?delete=<?= $r['id'] ?>" onclick="return confirm('Delete result record?')">
                      <i class="bi bi-trash"></i> Delete
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
