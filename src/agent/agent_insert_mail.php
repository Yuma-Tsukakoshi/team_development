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

// メール送信
$to = $_POST['mail'];
$subject = "新規企業登録ありがとうございます";
$message = "ご登録いただきありがとうございます。\n";
$message .= "審査の結果、企業掲載を承認させていただきます。\n";
$message .= "こちらのログイン画面URLから御社に申請された学生の一覧をご確認ください。\n";
$message .= "http://localhost:8080/agent/agent_auth/agent_login.php";
$headers = "From: admin@mail.com";

$result = mail($to, $subject, $message, $headers);

if ($result) {
    echo "メールが送信されました";
} else {
    echo "メールの送信に失敗しました";
}


?>
