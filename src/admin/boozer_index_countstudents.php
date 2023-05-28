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
  <h1>各企業にメールが送信されました。</h1>

  <?php
// データベースに接続する
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();

// 現在の月を取得する
$current_month = date('n');

// managers.mailを取得する
$sql1 = "SELECT mail FROM managers";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// user_register_clientテーブルと結合し、学生の数を数える
$sql2 = "SELECT managers.mail, COUNT(user_register_client.user_id) AS count
        FROM managers
        JOIN user_register_client ON managers.client_id = user_register_client.client_id
        JOIN users ON user_register_client.user_id = users.id
        WHERE MONTH(users.updated_at) = $current_month
        GROUP BY managers.mail";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// メール送信処理
if (!empty($result1)) {
  // メール送信の設定
  $subject = '【今月の申し込み人数】';
  $headers = 'From: admin@mail' . "\r\n" .
            'Reply-To: admin@mail' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

  // 各企業ごとにメールを送信する
  foreach ($result1 as $data1) {
    $mail = $data1['mail'];
    $message = "お世話になっております。\n\n";
    $message .=   "今月の申込人数は" . "\n";
    $count_found = false;
    foreach ($result2 as $data2) {
      if ($mail === $data2['mail']) {
        $message .=  $data2['count'] . "人" . "\n";
        $count_found = true;
      }
    }
    if (!$count_found) {
      $message .= "0人\n";  // データが見つからなかった場合は0を表示
    }
    $message .= "です。\n以上です。よろしくお願いいたします。\n";
    $subject_with_date = str_replace('◻︎', $current_month, $subject);
    mail($mail, $subject_with_date, $message, $headers);
  }
}


// データベースから切断する
$pdo = null;
?>