<?php
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$sql_1 = "UPDATE clients SET 
agent_name=:agent_name,service_name =:service_name ,started_at=:started_at,ended_at=:ended_at,catchphrase=:catchphrase,recommend_point1=:recommend_point1,recommend_point2=:recommend_point2,recommend_point3=:recommend_point3, logo_img =:logo_img 
WHERE client_id = :id";

$sql_2 = "UPDATE managers SET 
manager=:manager,depart =:depart ,mail=:mail,phone =:phone
WHERE client_id = :id";

$sql = "INSERT INTO invalid_reason(user_id, client_id, reason) VALUES(:uid, :client_id, :reason)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":uid", $_SERVER["id"]);
$stmt->bindValue(":client_id", $_SESSION["id"]);
$stmt->bindValue(":reason", $_POST["reason"]);
$stmt->execute();


$params1 = [
  "id" => $_POST["client_id"],
  "agent_name" => $_POST["agent_name"],
  "service_name" => $_POST["service_name"],
  "started_at" => $_POST["started_at"],
  "ended_at" => $_POST["ended_at"],
  "catchphrase" => $_POST["catchphrase"],
  "recommend_point1" => $_POST["recommend_point1"],
  "recommend_point2" => $_POST["recommend_point2"],
  "recommend_point3" => $_POST["recommend_point3"],
  // ↓ゆくゆくは画像アップロードする
  "logo_img" => $_POST["logo_img"],
];
$params2 = [
  "id" => $_POST["client_id"],
  "manager" => $_POST["manager"],
  "depart" => $_POST["depart"],
  "mail" => $_POST["mail"],
  "phone" => $_POST["phone"],
];

$pdo->beginTransaction();
try {
  // TODO:後々、企業のロゴをimgフォルダから取ってくるかも
  // TODO: inputがフォルダのアップロードに切り替わ絵たほうが良い！？
  // if (isset($params["image"])) {
  //   //「isset」はその変数が存在するかどうかを判定 "" もtrue
  //   $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  //   $image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
  //   move_uploaded_file(
  //     $_FILES['image']['tmp_name'],
  //     $image_path
  //   );
  //   $params["image"] = $image_name;
  // }

  $stmt1 = $pdo->prepare($sql_1);
  $result1 = $stmt1->execute($params1);
  $stmt2 = $pdo->prepare($sql_2);
  $result2 = $stmt2->execute($params2);
  // executeに連想配列を渡して各バインド変数に代入 bindValueで値を入れるときに複数ある場合はこっちのほうがいい
  // labelsの内容を変更させる⇒後でこれは考える
  $pdo->commit();
  header("Location: " . "http://localhost:8080/admin/boozer_index.php");
} catch (Error $e) {
  $pdo->rollBack();
}

?>
