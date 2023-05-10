<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$sql = "SELECT COUNT(*) FROM users INNER JOIN user_register_client AS relation ON users.id = relation.user_id WHERE (valid = 1 OR valid = 2) AND relation.client_id = :id ORDER BY updated_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_SESSION["id"]);
$stmt->execute();
$count= $stmt->fetch();
?>
