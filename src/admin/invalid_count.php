<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$count = $pdo->query("SELECT COUNT(*) FROM users INNER JOIN user_register_client AS r ON r.user_id = users.id WHERE valid = 1 OR valid = 2")->fetchAll(PDO::FETCH_ASSOC);

?>
