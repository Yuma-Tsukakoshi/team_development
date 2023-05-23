<?php
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();
$user_id = $_GET['user_id']; // agent_boozer.phpから渡されたuser_id
$client_id = $_GET['client_id']; // agent_boozer.phpから渡されたclient_id


// 削除処理を実行
$sql = "UPDATE user_register_client SET is_valid = false WHERE client_id = :client_id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':client_id', $client_id);
$stmt->execute();


// 削除完了メッセージをセットしてリダイレクト
$message = "学生情報を削除しました。";
header("Location:http://localhost:8080/agent/agent_boozer.php");
exit();

?>
