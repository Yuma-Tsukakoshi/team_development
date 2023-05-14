<?php
session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();

$inputVal = $_POST['input'];
if($inputVal == "ascending"){
  $sort = "hurigana ASC";
}else if($inputVal == "descending"){
  $sort = "hurigana DESC";
}else{
  $sort = "updated_at DESC";
}
$sql = "SELECT id, updated_at, name, hurigana, college, faculty, grad_year FROM users INNER JOIN user_register_client AS relation ON users.id = relation.user_id WHERE relation.valid = 1 ORDER BY $sort";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['invalid'] = $users;
