<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>承認完了</title>
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
  <h1>承認完了</h1>


<?php

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

// admin@mail.comへのメール
$to_admin = "admin@mail.com";
$subject_admin = "【株式会社boozer】学生登録のお知らせ";
$message_admin = "学生が登録をしました。";

send_email($to_admin, $subject_admin, $message_admin, $headers);

?>

<a href="http://localhost:8080/agent/agent_info/agent_disp_exam.php?id=9"><p>トップに戻る</p></a>
</body>
</html>