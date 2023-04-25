<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');


$params = [
  "content" => $_POST["content"],
  "supplement" => $_POST["supplement"],
  "id" => $_POST["question_id"],
];

//もし画像が既に入ってたら画像を更新する
if($_FILES["image"]["tmp_name"] !==""){
  $set__image = ", image = :image";
  $params["image"] = "";
  //paramsの連想配列に空の画像を入れる。
}
$sql = "UPDATE questions SET content=:content,supplement =:supplement $set__image WHERE id = :id";

$pdo->beginTransaction();
try{
  if(isset($params["image"])){
    //「isset」はその変数が存在するかどうかを判定 "" もtrue
    $image_name = uniqid(mt_rand(),true) . '.' . substr(strrchr($_FILES['image']['name'],'.'),1);
    $image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
    move_uploaded_file(
      $_FILES['image']['tmp_name'],
      $image_path
    );
    $params["image"] = $image_name; 
  }

  $stmt = $pdo->prepare($sql);
  $result = $stmt->execute($params);
  // executeに連想配列を渡して各バインド変数に代入 bindValueで値を入れるときに複数ある場合はこっちのほうがいい
  $sql = "DELETE FROM choices WHERE question_id = :question_id";
  $stmt = $pdo->prepare($sql);
  $stmt -> bindValue(":question_id",$_POST["question_id"]);
  $stmt -> execute();

  $sql = "INSERT INTO choices(name,valid,question_id) VALUE(:name,:valid,:question_id)";
  $stmt = $pdo->prepare($sql);
  for($i=0;$i<count($_POST["choices"]);$i++){
    $stmt ->execute([
      "name" => $_POST["choices"][$i],
      "valid" =>(int)$_POST["correctChoice"] === $i+1 ? 1 : 0,
      //$_POST["correctChoice"]にはチェックが入ってるラジオボタンのvalueが入ってる
      "question_id" => $_POST["question_id"]
    ]);
  }
  $pdo->commit();
  header("Location: "."http://localhost:8080/admin/index.php");
} catch(Error $e){
  $pdo->rollBack();
}

