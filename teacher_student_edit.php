<?php
require_once 'includes/header.php'; if($user['role']!='teacher') die('Unauthorized');
$id = isset($_GET['id'])?intval($_GET['id']):0; if(!$id) header('Location: teacher_students.php');
// assigned classes
$stmt = $conn->prepare('SELECT DISTINCT class FROM teacher_assignments WHERE teacher_id=?'); $stmt->bind_param('i',$user['id']); $stmt->execute(); $cls_res = $stmt->get_result(); $classes=[]; while($c=$cls_res->fetch_assoc()) $classes[]=$c['class'];
if(empty($classes)) die('No classes assigned.');

// fetch student and ensure student's class in assigned classes
$s = $conn->prepare('SELECT * FROM students WHERE id=?'); $s->bind_param('i',$id); $s->execute(); $student = $s->get_result()->fetch_assoc();
if(!$student) header('Location: teacher_students.php');
if(!in_array($student['class'],$classes)) die('Unauthorized to edit this student.');
$err='';
if(isset($_POST['save'])){
  $roll=$_POST['roll_no']; $name=$_POST['name']; $class=$_POST['class']; $section=$_POST['section'];
  if(!in_array($class,$classes)) $err='Unauthorized class'; else{
    $stmt=$conn->prepare('UPDATE students SET roll_no=?,name=?,class=?,section=? WHERE id=?'); $stmt->bind_param('ssssi',$roll,$name,$class,$section,$id);
    if($stmt->execute()) header('Location: teacher_students.php'); else $err='Error: '.$conn->error;
  }
}
?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Student | EduPortal</title>
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
          <h2 class="h2 page-title mb-0">Edit Student</h2>
          <a class="btn btn-secondary" href="teacher_students.php"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <?php if($err): ?>
          <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div><?=esc($err)?></div>
          </div>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-6">
            <div class="card p-4">
              <h5 class="card-title mb-4"><i class="bi bi-pencil-square text-primary me-2"></i>Student Details</h5>
              <form method="post">
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Roll Number</label>
                  <input name="roll_no" value="<?=esc($student['roll_no'])?>" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Full Name</label>
                  <input name="name" value="<?=esc($student['name'])?>" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Class</label>
                  <select name="class" class="form-select">
                    <?php foreach($classes as $c): ?>
                      <option value="<?=esc($c)?>" <?=($student['class']==$c)?'selected':''?>><?=esc($c)?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold text-muted">Section</label>
                  <input name="section" value="<?=esc($student['section'])?>" class="form-control">
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