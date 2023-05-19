<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$exam = $pdo->query("SELECT COUNT(*) FROM clients WHERE ended_at >= CURDATE() AND is_valid=true AND exist= 0")->fetchAll(PDO::FETCH_ASSOC);
