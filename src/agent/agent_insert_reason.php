<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');
session_start();

$pdo = Database::get();
$pdo->beginTransaction();

$sql = "INSERT INTO invalid_reason(user_id, client_id, reason) VALUES(:uid, :client_id, :reason)";
$id = $pdo->lastInsertId();
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":uid", $_GET["id"]);
$_SESSION['client_id'] = $_POST["client_id"];
$stmt->bindValue(":client_id", $_SESSION["client_id"]);
if($_POST["reason_text"] == ""){
  $stmt->bindValue(":reason", $_POST["reason"]);
}else{
  $stmt->bindValue(":reason", $_POST["reason_text"]);
}
$stmt->execute();

$sql2 = "UPDATE user_register_client SET valid = 1 WHERE user_id = :uid AND client_id = :client_id";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(":uid", $_GET["id"]);
$stmt2->bindValue(":client_id", $_SESSION["client_id"]);
$stmt2->execute();

$pdo->commit();

session_write_close();

header('Location: http://localhost:8080/agent/agent_boozer.php');
exit();
?>
