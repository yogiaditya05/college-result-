<?php
require_once 'includes/header.php'; if($user['role']!='teacher') die('Unauthorized');
$id = isset($_GET['id'])?intval($_GET['id']):0; if(!$id) header('Location: teacher_students.php');
// assigned classes
$stmt = $conn->prepare('SELECT DISTINCT class FROM teacher_assignments WHERE teacher_id=?'); $stmt->bind_param('i',$user['id']); $stmt->execute(); $cls_res = $stmt->get_result(); $classes=[]; while($c=$cls_res->fetch_assoc()) $classes[]=$c['class'];
if(empty($classes)) die('No classes assigned.');
// fetch student
$s = $conn->prepare('SELECT * FROM students WHERE id=?'); $s->bind_param('i',$id); $s->execute(); $student = $s->get_result()->fetch_assoc();
if(!$student) header('Location: teacher_students.php');
if(!in_array($student['class'],$classes)) die('Unauthorized to delete this student.');
$stmt = $conn->prepare('DELETE FROM students WHERE id=?'); $stmt->bind_param('i',$id); $stmt->execute();
header('Location: teacher_students.php'); exit;
?>