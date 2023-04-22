<?php

require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();

$agents = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);



?>
