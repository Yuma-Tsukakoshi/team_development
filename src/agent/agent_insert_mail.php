<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込み完了</title>
    <!-- スタイルシート読み込み -->
    <link rel="stylesheet" href="./user/assets/styles/common.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="./../assets/js/jquery.zip2addr.js"></script>
</head>
<body>
  <h1>新規登録企業にメールが送信されました。</h1>
    <a href="http://localhost:8080/admin/boozer_agent_exam.php">企業申請一覧に戻る</a>

  <?php
// データベースに接続する
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $mail = $_POST["mail"];
  var_dump($mail);
  $stmt1 = $pdo->prepare($mail);
  $stmt1->execute();
  $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

  // 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
function send_email($to, $subject, $message, $headers) {
    if (mail($to, $subject, $message, $headers)) {
    } else {
        echo "メールの送信に失敗しました。\n";
        echo "エラー情報: " . error_get_last()['message'];
    }
    }
  
  // user@mail.comへのメール
  $to_client = "$mail";
  $subject_client = "【株式会社boozer】お申し込みありがとうございます";
  $subject_client = "【株式会社boozer】お申し込みありがとうございます";
  $message_client = "※このメールはシステムからの自動返信です\n\n";
  $message_client .= "お世話になっております。\n";
  $message_client .= "株式会社boozerへのお問い合わせありがとうございました。\n\n";
  $message_client .= "お手数ですがお間違いないかご確認ください。\n\n";
  $message_client .= "●営業日以内に、担当者よりご連絡いたしますので\n";
  $message_client .= "今しばらくお待ちくださいませ。\n\n";
  
  send_email($to_client, $subject_client, $message_client, $headers);
}

?>