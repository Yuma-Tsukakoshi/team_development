<?php
require_once(dirname(__FILE__) . './../../dbconnect.php');
session_start();
$pdo=Database::get();

try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare("INSERT INTO users(name,hurigana,sex,birthday,college,faculty,department,division,grad_year,prefecture,mail,phone) VALUES(:name,:hurigana,:sex,:birthday,:college,:faculty,:department,:division,:grad_year,:prefecture,:mail,:phone)");
  $stmt->execute([
    "name" => $_POST["name"],
    "hurigana" => $_POST['hurigana'],
    "sex" => $_POST["sex"],
    "birthday" => $_POST["birthday"],
    "college" => $_POST["college"],
    "faculty" => $_POST["faculty"],
    "department" => $_POST["department"],
    "division" => $_POST["division"],
    "grad_year" => $_POST["grad_year"],
    "prefecture" => $_POST["prefecture"],
    "mail" => $_POST["email"],
    "phone" => $_POST["phone"],
  ]);

  $id = $pdo -> lastInsertId();
  foreach($_POST['company'] as $company){
    $stmt=$pdo->prepare("SELECT * FROM clients where agent_name = :agent_name");
    $stmt->bindValue(":agent_name",$company);
    $stmt->execute();
    $result = $stmt->fetch();

    $stmt = $pdo->prepare("INSERT INTO user_register_client(user_id,client_id) VALUES(:user_id,:client_id)");
    $stmt->execute([
      "user_id" => $id,
      "client_id" => $result['client_id'],
    ]);
  }
// client_idが一致するmailをとってくる
$client_id = $result['client_id'];
$stmt = $pdo->prepare("SELECT mail FROM managers WHERE client_id = :client_id");
$stmt->bindParam(':client_id', $client_id);
$stmt->execute();
$mail = $stmt->fetchColumn();

  //session消去
  unset($_SESSION['clients']);
  $pdo->commit();

  header('Content-type:application/json; charset=utf8');
  $result='投稿が完了しました';
  echo json_encode($result);


}catch(\Exception $e){
  $pdo->rollBack();
  exit($e->getMessage());
}

// メール機能
// 送信元のメールアドレス
$from = "craft@mail.com";

// 追加ヘッダー情報
$headers = "From:" . $from;

// 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
function send_email($to, $subject, $message, $headers) {
  if (mail($to, $subject, $message, $headers)) {
  } else {
    echo "メールの送信に失敗しました。\n";
    echo "エラー情報: " . error_get_last()['message'];
  }
}

// user@mail.comへのメール
$to_user = $_POST["email"];
$subject_user = "【株式会社boozer】お申し込みありがとうございます";
$subject_user = "【株式会社boozer】お申し込みありがとうございます";
$message_user = "※このメールはシステムからの自動返信です\n\n";
$message_user .= "株式会社boozerでの新規登録ありがとうございました。\n\n";
$message_user .= "お申し込みいただいた企業から担当者よりご連絡いたしますので\n";
$message_user .= "今しばらくお待ちくださいませ。\n\n";

send_email($to_user, $subject_user, $message_user, $headers);

// client@mail.comへのメール
$to_client =$mail;
$subject_client = "【株式会社boozer】学生登録のお知らせ";
$message_client = "お世話になっております。\n";
$message_client .= "株式会社boozerでございます。\n\n";
$message_client .= "CRAFTを通して学生より貴社の就活エージェントにお申込みいただいたことを通知いたします。詳しくはCRAFTよりご覧ください。\n\n";
$message_client .= "なお、営業時間は平日9時〜18時となっております。\n";
$message_client .= "時間外のお問い合わせは翌営業日にご連絡差し上げます。\n\n";
$message_client .= "ご理解・ご了承の程よろしくお願い致します。";

send_email($to_client, $subject_client, $message_client, $headers);

// admin@mail.comへのメール
$to_admin = "admin@mail.com";
$subject_admin = "【株式会社boozer】学生登録のお知らせ";
$message_admin = "学生が登録をしました。";

send_email($to_admin, $subject_admin, $message_admin, $headers);

?>