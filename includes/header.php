<?php
if(session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user'])){
    header('Location: index.php'); exit;
}
$user = $_SESSION['user'];
?>