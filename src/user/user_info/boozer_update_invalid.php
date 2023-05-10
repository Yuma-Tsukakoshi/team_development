<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$inputVal = $_POST['input'];
$sql = "UPDATE user_register_client SET valid = :valid WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":valid", (int)$inputVal);
$stmt->bindValue(":uid", $_SERVER["id"]);
$stmt->bindValue(":client_id", $_SESSION["id"]);
$stmt->execute();

