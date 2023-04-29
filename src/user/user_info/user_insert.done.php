<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込み完了</title>
</head>
<body>
  <h1>申し込みが完了しました。</h1>


<?php
// POSTデータを取得
$name = $_POST['name'];
$hurigana = $_POST['hurigana'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$birthday = $_POST['birthday'];
$prefecture = $_POST['prefecture'];
$college = $_POST['college'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];
$division = $_POST['division'];
$grad_year = $_POST['grad_year'];

// 宛先のメールアドレス
$to = "user@mail.com";

// 件名
$subject = "【株式会社boozer】お申し込みありがとうございます";

// メッセージ本文

$message = "※このメールはシステムからの自動返信です\n\n";
$message .= "お世話になっております。\n";
$message .= "株式会社boozerへのお問い合わせありがとうございました。\n\n";
$message .= "以下の内容でお問い合わせを受け付けいたしました。\n";
$message .= "お手数ですがお間違いないかご確認ください。\n\n";
$message .= "●営業日以内に、担当者よりご連絡いたしますので\n";
$message .= "今しばらくお待ちくださいませ。\n\n";

// ここで上書きではなく、追加するように変更します。
$message .= "名前: {$name}\n";
$message .= "ふりがな: {$hurigana}\n";
$message .= "メールアドレス: {$email}\n";
$message .= "電話番号: {$phone}\n";
$message .= "性別: {$sex}\n";
$message .= "生年月日: {$birthday}\n";
$message .= "住まいの都道府県: {$prefecture}\n";
$message .= "大学名: {$college}\n";
$message .= "学部: {$faculty}\n";
$message .= "学科: {$department}\n";
$message .= "文理: {$division}\n";
$message .= "卒業年度: {$grad_year}\n";

// 送信元のメールアドレス
$from = "client@mail.com";

// 追加ヘッダー情報
$headers = "From:" . $from;

// メールの送信
if(mail($to, $subject, $message, $headers)) {
  echo "<p>メールが送信されました。</p>";
} else {
  echo "メールの送信に失敗しました。\n";
  echo "エラー情報: " . error_get_last()['message'];
}
?>

<a href="../assets/index.html"><p>トップに戻る</p></a>
</body>
</html>
