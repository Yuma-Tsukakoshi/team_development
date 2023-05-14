<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();
$id = $_GET['id'];


// 削除処理を実行
$sql = "UPDATE users SET valid=false WHERE client_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $id]);

// 削除完了メッセージをセットしてリダイレクト
$message = "クライアント情報を削除しました。";
header("Location: http://localhost:8080/admin/boozer_index.php?message=" . urlencode($message));
exit();
?>
