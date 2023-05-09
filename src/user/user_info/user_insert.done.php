<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込み完了</title>
    <!-- スタイルシート読み込み -->
    <link rel="stylesheet" href="./admin/assets/styles/common.css">
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
<a href="../assets/index.html"><p>トップに戻る</p></a>
</body>
</html>

<?php
require_once(dirname(__FILE__) . './../../dbconnect.php');
session_start();
$pdo=Database::get();

try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare("INSERT INTO admins(name,hurigana,sex,birthday,college,faculty,department,division,grad_year,prefecture,mail,phone) VALUES(:name,:hurigana,:sex,:birthday,:college,:faculty,:department,:division,:grad_year,:prefecture,:mail,:phone)");
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

    $stmt = $pdo->prepare("INSERT INTO admin_register_client(admin_id,client_id) VALUES(:admin_id,:client_id)");
    $stmt->execute([
      "admin_id" => $id,
      "client_id" => $result['client_id'],
    ]);
  }
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
?>