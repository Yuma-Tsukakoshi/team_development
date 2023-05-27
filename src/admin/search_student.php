<?php
session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();

$data = $_POST['data'];
if(empty($data)){
  $sql = "SELECT * FROM users WHERE is_valid=true ORDER BY updated_at DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
  $sql = "SELECT * FROM users WHERE is_valid=true and DATE_FORMAT(updated_at, '%Y%m')=:data  ORDER BY updated_at DESC";
  $stmt = $pdo->prepare($sql);
  $stmt -> bindValue(':data',$data);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$_SESSION['month'] = $users;

?>

