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
$sql = "SELECT * FROM users INNER JOIN user_register_client AS r ON users.id = r.user_id WHERE r.client_id = :id AND (valid = 1 OR valid = 2) ORDER BY $sort";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_SESSION["id"]);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['invalid_agent_sort'] = $users;

?>

