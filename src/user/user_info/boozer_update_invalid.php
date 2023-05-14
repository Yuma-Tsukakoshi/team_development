<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$inputVal = isset($_POST['input']) ? $_POST['input'] : null;
$inputId = isset($_POST['inputId']) ? $_POST['inputId'] : null;

// クライアントのメールアドレスを取得
$sql = "SELECT managers.mail
        FROM clients
        JOIN managers ON clients.client_id = managers.client_id
        WHERE clients.client_id = :client_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":client_id", $inputId);
$stmt->execute();

// 結果を取得
$result = $stmt->fetch();
$mail = $result['mail']; // メールアドレスを取得

// ユーザーのメールアドレスを取得
$userSql = "SELECT mail FROM users WHERE id = :id";
$userStmt = $pdo->prepare($userSql);
$userStmt->bindValue(":id", $_SESSION["uid"]);
$userStmt->execute();
$userEmail = $userStmt->fetchColumn();

// 承認または却下の処理
if ($inputVal == 2) {
    // 承認の処理
    // 承認のメールを送信
    $to = $mail;
    // ...
} elseif ($inputVal == 3) {
    // 却下の処理
    // 却下のメールを送信
    $to = $mail;
    // ...
}

// 申請中の更新
$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", $inputVal);
$stmt->bindValue(":uid", $_SESSION["uid"]);
$stmt->bindValue(":client_id", $inputId);
$stmt->execute();
?>
