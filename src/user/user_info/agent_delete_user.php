<?php
require_once(dirname(__FILE__) . '../../../dbconnect.php');
$pdo = Database::get();
$id = $_GET['id'];

// 削除処理を実行
$sql = "UPDATE user_register_client SET is_valid=false WHERE user_id = :id" ;
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $id]);

// 削除完了メッセージをセットしてリダイレクト
$message = "学生情報を削除しました。";
header("Location: http://localhost:8080/admin/boozer_student.php?message=" . urlencode($message));
exit();

?>