<?php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'college_result';
$DB_USER = 'root';
$DB_PASS = '';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if($conn->connect_error) die('DB ERROR: '.$conn->connect_error);
$conn->set_charset('utf8mb4');
function esc($v){ return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8'); }
?>