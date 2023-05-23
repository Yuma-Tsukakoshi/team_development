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