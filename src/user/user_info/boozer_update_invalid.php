<?php
session_start();

require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = $_POST['data'];
$clientId = $_POST['clientId'];

$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", $data);
$stmt->bindValue(":uid", $_SESSION["uid"]);
$stmt->bindValue(":client_id", $clientId);
$stmt->execute();

// 企業へのメールアドレスを取得
$sql3 = "SELECT mail FROM managers WHERE client_id = :client_id";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindValue(":client_id", $clientId);
$stmt3->execute();
$manager = $stmt3->fetch(PDO::FETCH_ASSOC);

$headers = 'From: admin@mail' . "\r\n" .
    'Reply-To: admin@mail' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// 企業宛のメール
$to_manager = $manager["mail"];
$subject_manager = "【株式会社boozer】申請承認のお知らせ";
$message_manager = "※このメールはシステムからの自動返信です\n\n";
$message_manager .= "株式会社boozerでの新規登録ありがとうございました。\n\n";
$message_manager .= "無効申請を承認させていただきました。\n";
$message_manager .= "詳しくはCRAFTのページをご覧ください\n\n";
$message_manager .= "ご不明点あれば連絡ください\n\n";

// 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
function send_email($to, $subject, $message, $headers) {
    if (mail($to, $subject, $message, $headers)) {
    } else {
        echo "メールの送信に失敗しました。\n";
        echo "エラー情報: " . error_get_last()['message'];
    }
}

send_email($to_manager, $subject_manager, $message_manager, $headers);
?>

