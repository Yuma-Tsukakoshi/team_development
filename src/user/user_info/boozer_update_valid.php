<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$data = $_POST['data'];
$clientId = $_POST['clientId'];

$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", $data);
$stmt->bindValue(":uid", $_SESSION["uid"]);
$stmt->bindValue(":client_id", $clientId);
$stmt->execute();

// 理由取得
$sql1 = "SELECT reason FROM invalid_reason WHERE user_id = :uid AND client_id = :client_id;";
$stmt1 = $pdo->prepare($sql1);
$stmt1->bindValue(":uid", $_SESSION["uid"]);
$stmt1->bindValue(":client_id", $clientId);
if ($stmt1->execute()) {
    $reasonRow = $stmt1->fetch(PDO::FETCH_ASSOC);
    if ($reasonRow) {
        $reason = $reasonRow['reason']; // 理由の値を $reason 変数に代入
    } else {
        $reason = "理由が見つかりませんでした。";
    }
} else {
    $reason = "データベースクエリの実行に失敗しました。";
}

// userへのメール
$sql2 = "SELECT mail FROM users WHERE id = :uid";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(":uid", $_SESSION["uid"]);
$stmt2->execute();
$user = $stmt2->fetch(PDO::FETCH_ASSOC);

$headers = 'From: admin@mail' . "\r\n" .
'Reply-To: admin@mail' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

// 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
function send_email($to, $subject, $message, $headers) {
    if (mail($to, $subject, $message, $headers)) {
    } else {
    echo "メールの送信に失敗しました。\n";
    echo "エラー情報: " . error_get_last()['message'];
    }
}

// user宛のメール
$to_user= $user["mail"];
$subject_user = "【株式会社boozer】申請拒否のお知らせ";
$message_user = "※このメールはシステムからの自動返信です\n\n";
$message_user .= "株式会社boozerでの新規登録ありがとうございました。\n\n";
$message_user .= $reason . "のため、申請を拒否させていただきました。\n";
$message_user .= "ご不明点があればご連絡ください\n\n";



?>