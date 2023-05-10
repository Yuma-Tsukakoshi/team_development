<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_count.php');

$pdo = Database::get();
$sql = "SELECT * FROM users WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$user = $stmt->fetch();

$sql2 = "SELECT clients.service_name, valid FROM user_register_client as relation INNER JOIN clients ON relation.client_id = clients.client_id WHERE user_id = :id";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(":id", $_REQUEST["id"]);
$stmt2->execute();
$agents = $stmt2->fetchAll();

$sql3 = "SELECT sub.service_name, reason.reason ,reason.user_id FROM invalid_reason as reason  RIGHT JOIN (SELECT clients.service_name , clients.client_id , relation.user_id FROM user_register_client as relation INNER JOIN clients ON relation.client_id = clients.client_id WHERE relation.user_id = :id ) AS sub ON sub.client_id = reason.client_id WHERE reason.user_id = :uid";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindValue(":id", $_REQUEST["id"]);
$stmt3->bindValue(":uid", $_REQUEST["id"]);
$stmt3->execute();
$invalid_agents = $stmt3->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../vendor/tailwind/tailwind.output.css">
  <link rel="stylesheet" href="../../admin/admin.css">
  <link rel="stylesheet" href="../assets/styles/badge.css">
  <script src="../assets/js/agent_send_valid.js" defer></script>
  <script src="../assets/js/agent_send_invalid.js" defer></script>
  <title>無効申請学生情報詳細</title>
</head>

<body>
  <div class="flex h-screen bg-gray-50" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <!-- side banner -->
    <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-slate-500 md:block">
      <div class="py-4 text-gray-500">
        <a class="ml-6 text-lg font-bold text-gray-800 " href="#">
          SideBanner
        </a>
        <ul class="mt-6">
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="../../admin/boozer_index.php">
              <span class="ml-4">企業一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
              <span class="ml-4">企業新規登録</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="../../admin/boozer_student.php">
              <span class="ml-4">学生一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <div class="notifier new">
              <div class="badge num"><?= $count[0]['COUNT(*)'] ?></div>
            </div>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="../../admin/invalid_student.php">
              <span class="ml-4">無効申請一覧</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <div class="flex flex-col flex-1 w-full">
      <main class="h-full pb-16 overflow-y-auto">
        <h1 class="my-6 text-2xl font-semibold text-gray-700 text-center">学生情報詳細 <?= $user["name"] ?> 様</h1>
        <!-- <div class="flex justify-center ">
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center  ">無効申請 : <a href="#" class="edit_btn">承認</a></p>
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center  ">無効申請 : <a href="#" class="edit_btn">拒否</a></p>
        </div> -->
        <div class="my-8 flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  申請企業一覧
                </th>
                <th scope="col" class="px-6 py-3 text-left text-lg font-medium uppercase tracking-wider">
                  無効申請判定
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php foreach ($agents as $agent) { ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <?= $agent["service_name"] ?>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <?php
                      if ($agent["valid"] == 0) {
                        print_r("申請なし");
                      } elseif ($agent["valid"] == 1) {
                        // それぞれdata-id入れて非同期で処理 承認=data-2 拒否=data-0でこのデータの数字をそのままvalidの更新に用いる 非同期jsファイル＆boozer_update_invalid.phpに記述
                        echo '<div class="flex  justify-between">
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center ">申請中</p>
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center ">無効申請 : <a href="#" id="valid_btn" class="edit_btn" data="2">承認</a></p>
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center  ">無効申請 : <a href="#" id="invalid_btn" class="edit_btn" data="0">拒否</a></p>
        </div>';
                      } else {
                        print_r("申請承認");
                      }
                      ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="my-8 flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  無効申請企業一覧
                </th>
                <th scope="col" class="px-6 py-3 text-left text-lg font-medium uppercase tracking-wider">
                  無効申請理由
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php foreach ($invalid_agents as $agent) { ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <?= $agent["service_name"] ?>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <?= $agent["reason"] ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  学生情報
                </th>
                <th scope="col" class="px-6 py-3 text-left text-lg font-medium uppercase tracking-wider">
                  データ
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    お問い合わせ日時
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["created_at"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    氏名
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["name"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    フリガナ
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["hurigana"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    性別
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["sex"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    生年月日
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["birthday"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    メールアドレス
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["mail"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    電話番号
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["phone"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    所在地
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["prefecture"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    大学
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["college"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    学部
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["faculty"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    学科
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["department"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    文理
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["division"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    卒業年
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $user["grad_year"] ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</body>

</html>
