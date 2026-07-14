<?php
$role = $user['role'];
$active = basename($_SERVER['PHP_SELF']);
?>
<nav class="col-md-2 d-none d-md-block sidebar">
  <div class="sidebar-header">
    <i class="bi bi-mortarboard-fill me-2"></i>EduPortal
  </div>
  <div class="position-sticky pt-2">
    <ul class="nav flex-column">
      <?php if($role=='admin'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='admin_dashboard.php')?'active':'' ?>" href="admin_dashboard.php">
            <i class="bi bi-speedometer2"></i> Admin Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='admin_manage_users.php' || $active=='admin_user_add.php' || $active=='admin_user_edit.php')?'active':'' ?>" href="admin_manage_users.php">
            <i class="bi bi-people"></i> Manage Users
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='admin_assign.php')?'active':'' ?>" href="admin_assign.php">
            <i class="bi bi-person-badge"></i> Assign Teachers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='students.php' || $active=='students_add.php' || $active=='students_edit.php')?'active':'' ?>" href="students.php">
            <i class="bi bi-mortarboard"></i> Manage Students
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='results.php' || $active=='results_add.php' || $active=='results_edit.php')?'active':'' ?>" href="results.php">
            <i class="bi bi-journal-check"></i> Manage Results
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='reports.php')?'active':'' ?>" href="reports.php">
            <i class="bi bi-graph-up"></i> Reports
          </a>
        </li>
      <?php elseif($role=='teacher'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='teacher_dashboard.php')?'active':'' ?>" href="teacher_dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='teacher_students.php' || $active=='teacher_student_add.php' || $active=='teacher_student_edit.php')?'active':'' ?>" href="teacher_students.php">
            <i class="bi bi-people"></i> My Students
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='teacher_results.php')?'active':'' ?>" href="teacher_results.php">
            <i class="bi bi-journal-check"></i> Manage Results
          </a>
        </li>
      <?php elseif($role=='student'): ?>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='student_dashboard.php')?'active':'' ?>" href="student_dashboard.php">
            <i class="bi bi-speedometer2"></i> My Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($active=='my_results.php')?'active':'' ?>" href="my_results.php">
            <i class="bi bi-award"></i> My Results
          </a>
        </li>
      <?php endif; ?>
      <hr style="border-top: 1px solid #334155; margin: 10px 0;">
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="bi bi-box-arrow-right"></i> Logout (<?=esc($user['name'])?>)
        </a>
      </li>
    </ul>
  </div>
</nav>