<?php
session_start();
$sql = "UPDATE user_register_client SET valid = 1 WHERE user_id = :uid AND client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":uid", $_SERVER["id"]);
$stmt->bindValue(":client_id", $_SESSION["id"]);
