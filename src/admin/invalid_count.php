<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$count = $pdo->query("SELECT COUNT(*) FROM users WHERE valid = 1 OR valid = 2")->fetchAll(PDO::FETCH_ASSOC);

?>
