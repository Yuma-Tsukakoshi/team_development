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
  <h1>申し込みが完了しました。</h1>
<a href="http://localhost:8080/user/assets/index.html">トップページへ</a>
<?php
require_once(dirname(__FILE__) . './../../dbconnect.php');

$pdo=Database::get();
try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare('SELECT MAX(client_id)+1 FROM clients');
  $stmt->execute();
  $id=$stmt->fetch(PDO::FETCH_ASSOC);
  
  $stmt = $pdo->prepare("INSERT INTO clients(client_id,agent_name,service_name,catchphrase,recommend_point1,recommend_point2,recommend_point3,started_at,ended_at,logo_img) VALUES(:client_id,:agent_name,:service_name,:catchphrase,:recommend_point1,:recommend_point2,:recommend_point3,:started_at,:ended_at,:logo_img)");
  $stmt->execute([
    "client_id" => $id["MAX(client_id)+1"],
    "agent_name" => $_POST["agent_name"],
    "service_name" => $_POST["service_name"],
    "catchphrase" => $_POST["catchphrase"],
    "recommend_point1" => $_POST["recommend_point1"],
    "recommend_point2" => $_POST["recommend_point2"],
    "recommend_point3" => $_POST["recommend_point3"],
    "started_at" => $_POST["started_at"],
    "ended_at" => $_POST["ended_at"],
    "logo_img" => $_POST["logo_img"],
  ]);
  
  $client_id = $pdo -> lastInsertId();
  

  $stmt = $pdo->prepare("INSERT INTO managers(client_id,manager,depart,mail,phone) VALUES(:client_id,:manager,:depart,:mail,:phone)");
  $params2 = [
    "client_id" => $client_id,
    "manager" => $_POST["manager"],
    "depart" => $_POST["depart"],
    "mail" => $_POST["mail"],
    "phone" => $_POST["phone"],
  ];
  $stmt->execute($params2);
  
  if($_POST['subject'][0]==0){
    $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES($client_id,1),($client_id,2)");
    $stmt->execute();
   
  }else{
    $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES(:client_id,:label_id)");
    $params3 = [
      "client_id" => $client_id,
      "label_id" => $_POST["subject"][0],
    ];
    $stmt->execute($params3);

  }
  

  foreach($_POST['contact'] as $data){
    $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES(:client_id,:label_id)");
    $params4 = [
      "client_id" => $client_id,
      "label_id" => $data,
    ];
    $stmt->execute($params4);

  }

  if (isset($_POST['place']) && is_array($_POST['place'])) {
    foreach($_POST['place'] as $data){
      $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES(:client_id,:label_id)");
      $params5 = [
        "client_id" => $client_id,
        "label_id" => $data,
      ];
      $stmt->execute($params5);
  
    }
    
  }
  
  //emailは登録に入らない？
  $stmt = $pdo->prepare("INSERT INTO client_login(client_id,password) VALUES(:client_id,:password)");
  $params6 = [
    "client_id" => $client_id,
    "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
  ];
  $stmt->execute($params6);


  
    
  $pdo->commit();

  //header("Location: " . "http://localhost:8080/admin/boozer_index.php");


}catch(\Exception $e){
  $pdo->rollBack();
  exit($e->getMessage());
}
// メール通知機能

// 送信元のメールアドレス
$from = "craft@mail.com";

// 追加ヘッダー情報
// 追加ヘッダー情報
$headers = "From: " . $from . "\r\n";
$headers .= "Reply-To: " . $from . "\r\n";
$headers .= "Return-Path: " . $from . "\r\n";
$headers .= "Organization: 株式会社boozer\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=iso-2022-jp\r\n";

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
$subject_admin = "新規企業登録のお知らせ";
$message_admin = "新規企業が登録されました\n\n";
send_email($to_admin, $subject_admin, $message_admin, $headers);

// $POST_["email"]へのメール
$to_client = $_POST["mail"];
$subject_client = "【株式会社boozer】企業新規登録のお知らせ";
$message_client = "お申し込みありがとうございます。\n";
$message_client .= "株式会社boozerでございます。\n\n";
$message_client .= "CRAFTを通して貴社の就活エージェントにお申込みいただいたことを通知いたします。\n\n";
$message_client .= "ご不明点あればcraft@mail.comまでご連絡ください。。\n\n";
$message_client .= "なお、営業時間は平日9時〜18時となっております。\n";
$message_client .= "時間外のお問い合わせは翌営業日にご連絡差し上げます。\n\n";
$message_client .= "ご理解・ご了承の程よろしくお願い致します。";
send_email($to_client, $subject_client, $message_client, $headers);
?>