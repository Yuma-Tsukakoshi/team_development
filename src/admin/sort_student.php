<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();


$users = $pdo->query("SELECT * FROM users ORDER BY updated_at ")->fetchAll(PDO::FETCH_ASSOC);
// print_r($users);
?>

