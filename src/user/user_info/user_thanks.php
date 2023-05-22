<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込み完了</title>
    <!-- スタイルシート読み込み -->
    <link rel="stylesheet" href="../assets/styles/common.css">
    <link rel="stylesheet" href="../assets/styles/cart.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./../../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../assets/styles/header.css">
  <link rel="stylesheet" href="../assets/styles/form.css">
  <link rel="stylesheet" href="../assets/styles/cart.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
  <header>
    <div class="header_wrapper">
      <div class="header_upper">
        <div class="craft_logo">CRAFT</div>
        <div class="boozer_logo"><img src="../user/assets/img/boozer_logo_white.png" alt="boozer Inc."></div>
      </div>
    </div>
  </header>
  <main>
    <div class="phase-image">
      <div class="first-box">カート一覧</div>
      <div class="border-line"></div>
      <div class="second-box">申し込み<span>フォーム</span></div>
      <div class="border-line"></div>
      <div class="third-box">申し込み<span>確認</span></div>
      <div class="border-line"></div>
      <div class="fourth-box">完了</div>

    </div>
    <div class="thanks-area">
      <div class="thanks-message">
        <div class="message-content">申し込みが完了<span>しました。</span></div>
        <div class="return-link">
          <a href="../assets/index.html">トップに戻る</a>
        </div>
      </div>
     
    </div>
  </main>


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

// user@mail.comへのメール
$to_user = "user@mail.com";
$subject_user = "【株式会社boozer】お申し込みありがとうございます";
$subject_user = "【株式会社boozer】お申し込みありがとうございます";
$message_user = "※このメールはシステムからの自動返信です\n\n";
$message_user .= "お世話になっております。\n";
$message_user .= "株式会社boozerへのお問い合わせありがとうございました。\n\n";
$message_user .= "以下の内容でお問い合わせを受け付けいたしました。\n";
$message_user .= "お手数ですがお間違いないかご確認ください。\n\n";
$message_user .= "●営業日以内に、担当者よりご連絡いたしますので\n";
$message_user .= "今しばらくお待ちくださいませ。\n\n";

send_email($to_user, $subject_user, $message_user, $headers);

// client@mail.comへのメール
$to_client = "client@mail.com";
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

</body>
<script>
  $('.first-box').css('background-color','#dcdcdc')
  $('.fourth-box').css('background-color','#ffff66')
  $('.fourth-box').toggleClass('active')


</script>

</html>