<?php require_once 'includes/header.php'; if($user['role']!='admin') die('Unauthorized');
$teachers = $conn->query("SELECT id,name FROM users WHERE role='teacher'")->fetch_all(MYSQLI_ASSOC);
$subjects = $conn->query('SELECT * FROM subjects')->fetch_all(MYSQLI_ASSOC);
if(isset($_POST['assign'])){
  $teacher_id = intval($_POST['teacher_id']); $class = $_POST['class']; $subject_id = isset($_POST['subject_id'])?intval($_POST['subject_id']):NULL;
  $stmt = $conn->prepare('INSERT INTO teacher_assignments (teacher_id,class,subject_id) VALUES (?,?,?)');
  $stmt->bind_param('isi',$teacher_id,$class,$subject_id); $stmt->execute(); header('Location: admin_assign.php'); exit;
}
if(isset($_GET['delete'])){ $id=intval($_GET['delete']); $stmt=$conn->prepare('DELETE FROM teacher_assignments WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute(); header('Location: admin_assign.php'); exit; }
$assignments = $conn->query('SELECT ta.*, u.name AS teacher_name, sub.title AS subject_title FROM teacher_assignments ta JOIN users u ON ta.teacher_id=u.id LEFT JOIN subjects sub ON ta.subject_id=sub.id ORDER BY ta.teacher_id')->fetch_all(MYSQLI_ASSOC);
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Assign Teachers | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Assign Classes & Subjects to Teachers</h2>
        </div>

        <!-- Add Assignment Form inside Card -->
        <div class="card p-4 mb-4">
          <h5 class="card-title mb-3"><i class="bi bi-link-45deg me-2 text-primary"></i>New Assignment</h5>
          <form method="post" class="row g-3 align-items-end">
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted">Select Teacher</label>
              <select name="teacher_id" class="form-select">
                <?php foreach($teachers as $t): ?>
                  <option value="<?=$t['id']?>"><?=esc($t['name'])?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted">Class Name</label>
              <input name="class" class="form-control" placeholder="e.g. B.Tech CSE" required>
            </div>
            <div class="col-md-3">
              <label class="form-label small fw-semibold text-muted">Subject (Optional)</label>
              <select name="subject_id" class="form-select">
                <option value="">-- Optional: Subject --</option>
                <?php foreach($subjects as $s): ?>
                  <option value="<?=$s['id']?>"><?=esc($s['code'].' - '.$s['title'])?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <button class="btn btn-primary w-100 py-2" name="assign">
                <i class="bi bi-plus-circle me-1"></i> Assign
              </button>
            </div>
          </form>
        </div>

        <!-- Assignments Table Container -->
        <div class="table-container">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Teacher</th>
                <th>Class</th>
                <th>Subject</th>
                <th style="width: 150px; text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($assignments as $a): ?>
                <tr>
                  <td><strong><?=esc($a['teacher_name'])?></strong></td>
                  <td><span class="badge bg-light text-dark border"><?=esc($a['class'])?></span></td>
                  <td><?=esc($a['subject_title']?:'--')?></td>
                  <td class="text-center">
                    <a class="btn btn-sm btn-outline-danger" href="?delete=<?=$a['id']?>" onclick="return confirm('Remove assignment?')">
                      <i class="bi bi-x-circle me-1"></i> Remove
                    </a>
                  </td>
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