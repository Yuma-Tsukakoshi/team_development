<?php

require_once(dirname(__FILE__) . '/../dbconnect.php');

$image_name = uniqid(mt_rand(),true) . '.' . substr(strrchr($_FILES['image']['name'],'.'),1);
//画像をユニーク化 fileneme.拡張子
//$_FILES:POSTでアップロードした画像を取得
//strrchr:(文字列,'文字')最後に該当する箇所を取得 (ex) ~[.png]
//substr(文字列,開始位置,文字数):文字数省略で最後まで取得
//['name']:ファイル名
$image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
move_uploaded_file(
  $_FILES['image']['tmp_name'],
  $image_path
);
//move_uploaded_file:指定した画像を、指定path先ディレクトリに保存する
//['tmp_name']:サーバー上で一時的に保存されるファイル名(ディレクトリ込み)

$stmt = $pdo->prepare("INSERT INTO questions(content,image,supplement) VALUES(:content,:image,:supplement)");
$stmt ->execute([
  "content"=> $_POST["content"],
  "image" => $image_name,
  "supplement" => $_POST["supplement"]
]);
$lastInsertId = $pdo->lastInsertId();
// lastInsertId:最後に挿入された行のIDを返す
//挿入したテーブルの主キーがAUTO INCREMENT(オートインクリメント)の自動連番であることが重要。※executeで実行後に割り振り

$stmt = $pdo->prepare("INSERT INTO choices(name,valid,question_id) VALUES(:name,:valid,:question_id)");

for($i = 0 ; $i< count($_POST["choices"]) ; $i++){
  $stmt->execute([
    "name" => $_POST["choices"][$i],
    "valid" =>(int)$_POST["correctChoice"] === $i + 1 ? 1 : 0,
    //チェックされたvalueの値が渡される
    "question_id" => $lastInsertId
  ]);
}

header("Location: ". "http://localhost:8080/admin/index.php");
// 指定されたサイトにリダイレクトして開く

