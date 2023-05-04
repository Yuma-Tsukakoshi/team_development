<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();

$inputVal = $_POST['inputVal']; 
echo $inputVal;
$sort = $inputVal=="ascending" ? "hurigana ASC": "hurigana DESC";
$sql = "SELECT * FROM users ORDER BY $sort";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

