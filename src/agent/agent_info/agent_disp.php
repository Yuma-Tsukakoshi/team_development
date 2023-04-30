<?php 

require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();
$sql = "SELECT * FROM clients WHERE client_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id",$GET["id"]);
$stmt->execute();
$agents= $stmt->fetch();

?>
