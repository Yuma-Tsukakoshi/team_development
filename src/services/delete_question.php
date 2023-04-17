<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo->beginTransaction();
//PDO::beginTransaction で開始されたトランザクションは、 PDO::commit または PDO::rollback が呼び出されたときに終了する。オートコミットオフ
try {
  $sql = "DELETE FROM choices WHERE question_id = :question_id";
  $stmt = $pdo-> prepare($sql);
  //$stmt変数:PDOstatementオブジェクト $pdoからprepareメソッドを呼び出して取得
  //prepare:データベースに発行したいsql命令を指定する
  // :変数 バインド変数 プレイスホルダーとなる
  $stmt->bindValue(":question_id", $_REQUEST["id"]);
  //bindValue:バインド変数に$REQUESTで取得したidを代入する
  //$_REQUEST:$_REQUESTは、$_GET／$_POST／$_COOKIEの値をまとめて扱える $GETの代わり <a>の?id=の[id]の値を取得する
  $stmt->execute();
  //excecute: 実行する

  $sql = "DELETE FROM questions WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":id",$_REQUEST["id"]);
  $stmt->execute();
  $pdo->commit();
  //commit:オートコミットオン
  header("HTTP/1.1 204 OK");
  //200番台 アクセス成功 ウェブサーバーにリクエストを送りレスポンスをOKと得る
  
} catch(Error $e) { 
  //Error $e : エラーを受け取る任意変数$e
  $pdo->rollBack();
  //rollBack:処理が失敗したときに前回commitした場所まで戻る->処理中は即時反映されず、上手く実行できた時に保存するイメージ
  header("HTTP/1.1 500 OK");
  //500アクセス不可能
}

// header("Content-Type application/json; charset=utf-8");
// JSON形式のデータを出力する際には、header関数で「Content-Type: application/json」を指定します。

// JSONのデータは文字コードがUTF-8なので「charset=utf-8」を指定します。
