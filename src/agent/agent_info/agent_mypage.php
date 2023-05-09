<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../vendor/tailwind/tailwind.output.css">
  <link rel="stylesheet" href="../../admin/admin.css">
  <link rel="stylesheet" href="../../user/assets/styles/badge.css">
  <title>csvダウンロード</title>
</head>

<body>
  <main>
  <a href="./agent_csv.php">
    <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray">csvダウンロード</button>
  </a>

  </main>
</body>
</html>
<?php
session_start();
require_once(dirname(__FILE__) . './../../dbconnect.php');
$pdo = Database::get();
$students = $pdo->query("SELECT * FROM users INNER JOIN user_register_client on users.id = user_register_client.user_id WHERE user_register_client.client_id=1")->fetchAll(PDO::FETCH_ASSOC);
print_r($students);