<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$inputVal = $_POST['input'];
$inputId = $_POST['inputId'];

$sql = "UPDATE clients SET exist = :exist WHERE client_id = :client_id;";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":exist", $inputVal);
$stmt->bindValue(":client_id", $inputId);
$stmt->execute();
