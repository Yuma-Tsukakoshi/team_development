<!-- SQL文を発行するページ -->
<?php
session_start();
require_once(dirname(__FILE__) . '../../dbconnect.php');
$pdo = Database::get();



// <!-- INSERT 文 -->
$sql = "INSERT INTO invalid_reason(user_id,client_id,reason) VALUES(:uid,:client_id,:reason)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":uid", $_SERVER["id"]);
$stmt->bindValue(":client_id", $_SESSION["client_id"]);
$stmt->execute();
// <!-- UPDATE文 -->
$sql2 = "UPDATE user_register_client SET valid=1 WHERE user_id= :uid AND client_id =:client_id;";
$stmt2=$pdo->prepare($sql2);
$stmt2->bindValue(":uid", $_SERVER["id"]);
$stmt2->bindValue(":client_id", $_SESSION["client_id"]);
$stmt2->execute();

// <!-- Header location リダイレクト agent_boozer.php -->

header('Location:http://localhost:8080/agent/agent_boozer.php');
exit();


?>