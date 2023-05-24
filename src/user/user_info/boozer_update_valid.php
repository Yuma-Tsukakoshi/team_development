<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$inputVal = $_POST['input'];
$inputId = $_POST['inputId'];

$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", $inputVal);
$stmt->bindValue(":uid", $_SESSION["uid"]);
$stmt->bindValue(":client_id", $inputId);
$stmt->execute();


// メール機能
// clientへのメール
// $sql1 = "SELECT mail FROM managers WHERE client_id = :client_id";
// $stmt1 = $pdo->prepare($sql1);
// $stmt1->bindValue(":client_id", $inputId);
// $stmt1->execute();
// $manager_mail = $stmt1->fetchAll(PDO::FETCH_COLUMN);

// $headers = 'From: admin@mail' . "\r\n" .
// 'Reply-To: admin@mail' . "\r\n" .
// 'X-Mailer: PHP/' . phpversion();

// 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
// function send_email($to, $subject, $message, $headers) {
//     if (mail($to, $subject, $message, $headers)) {
//     } else {
//     echo "メールの送信に失敗しました。\n";
//     echo "エラー情報: " . error_get_last()['message'];
//     }
// }


// manager宛のメール
// $to_client = $manager_mail;
// $subject_client = "【株式会社boozer】学生登録のお知らせ";
// $message_client = "お世話になっております。\n";
// $message_client .= "株式会社boozerでございます。\n\n";
// $message_client .= "CRAFTを通して学生より貴社の就活エージェントにお申込みいただいたことを通知いたします。詳しくはCRAFTよりご覧ください。\n\n";
// $message_client .= "なお、営業時間は平日9時〜18時となっております。\n";
// $message_client .= "時間外のお問い合わせは翌営業日にご連絡差し上げます。\n\n";
// $message_client .= "ご理解・ご了承の程よろしくお願い致します。";

// send_email($to_client, $subject_client, $message_client, $headers);

?>