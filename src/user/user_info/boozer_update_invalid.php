<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$inputVal = $_POST['input'];
$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", $inputVal);
//読み込みがされてないからエラーが出る⇒user_idのsessionを用いる
$stmt->bindValue(":uid", $_SESSION["uid"]);
$stmt->bindValue(":client_id", $_SESSION["id"]);
$stmt->execute();

