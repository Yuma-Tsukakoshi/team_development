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
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/invalid_count.php');


// データベースから担当者情報を取得する
$pdo = Database::get();
$managers = $pdo->query("SELECT * FROM managers")->fetchAll(PDO::FETCH_ASSOC);

// 企業別に当月のuser申し込み数をカウントする
$sql = "SELECT c.agent_name, COUNT(c.client_id) AS count u.created_at
        FROM clients c
        LEFT JOIN user_register_client urc ON c.client_id = urc.client_id
        LEFT JOIN users u ON urc.user_id = u.id
        -- HAVING u.created_at LIKE '$current_month%'
        GROUP BY c.client_id";
$counts = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT c.agent_name, u.created_at
        FROM clients c
        LEFT JOIN user_register_client urc ON c.client_id = urc.client_id
        LEFT JOIN users u ON urc.user_id = u.id
        DATE_FORMAT(u.created_at,'%Y%m') = DATEFORMAT(NOW(),'%Y%m')
        ";



// headers関数を定義
$headers = 'From: sender@example.com' . "\r\n" .
            'Reply-To: sender@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

// 各担当者にメールを送信する
foreach ($managers as $manager) {
    $to = $manager['mail'];
    $subject = "【今月の申し込み人数】";
    $message = "お世話になっております。\n\n";
    $message .= "以下の企業の当月の申し込み数をお知らせいたします。\n\n";

    // 担当者に対応する企業の申し込み数をメッセージに追加する
    foreach ($counts as $count) {
        if ($count['agent_name'] == $manager['manager']) {
            $message .= "{$count['agent_name']}: {$count['count']}人です。\n";
        }
    }
    $message .= "\n以上です。よろしくお願いいたします。\n";
    // メールを送信する
    if (!mail($to, $subject, $message, $headers)) {
        echo "メールの送信に失敗しました。\n";
    }
}

?>

