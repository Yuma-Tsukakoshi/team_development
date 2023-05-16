<?php

session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/invalid_count.php');

$pdo = Database::get();

// 削除成功時のメッセージ
if (isset($_GET['message']) && $_GET['message'] === 'deleted') {
  $message = "削除しました。";
}

// クライアント情報を取得
$sql = "SELECT * FROM clients";
$stmt = $pdo->query($sql);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);


$agents1 = $pdo->query("SELECT * FROM clients WHERE ended_at >= CURDATE() AND is_valid=true AND exist=true")->fetchAll(PDO::FETCH_ASSOC);
// var_dump($agents1);
$agents2 = $pdo->query("SELECT * FROM clients WHERE ended_at < CURDATE() AND is_valid=true AND exist=true")->fetchAll(PDO::FETCH_ASSOC);
// var_dump($agents2);

$exist_count = $pdo->query("SELECT COUNT(*) FROM clients WHERE ended_at >= CURDATE()")->fetch();
$non_exist_count = $pdo->query("SELECT COUNT(*) FROM clients WHERE ended_at < CURDATE()")->fetch();

// 今月の登録があった企業数だけを取得
$sql4 = "SELECT relation.client_id, users.created_at,COUNT(relation.client_id) AS sum
FROM user_register_client as relation 
INNER JOIN clients ON relation.client_id = clients.client_id 
INNER JOIN users ON relation.client_id = users.id
WHERE MONTH(users.created_at) = MONTH(CURRENT_DATE()) AND YEAR(users.created_at) = YEAR(CURRENT_DATE())
GROUP BY relation.client_id 
ORDER BY relation.client_id ASC";
$agent_count = $pdo->query($sql4)->fetchAll(PDO::FETCH_ASSOC);


// if (!isset($_SESSION['id'])) {
//     header('Location: http://localhost:8080/admin/boozer_auth/boozer_signup.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.output.css">
  <link rel="stylesheet" href="../user/assets/styles/badge.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/DeuxHuitHuit/quicksearch/dist/jquery.quicksearch.min.js" defer></script>
  <title>boozer企業一覧</title>
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
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
              <span class="ml-4">企業一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
              <span class="ml-4">企業申請一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="./boozer_student.php">
              <span class="ml-4">学生一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <div class="notifier new">
              <div class="badge num"><?= $count[0]['COUNT(*)'] ?></div>
            </div>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="./invalid_student.php">
              <span class="ml-4">無効申請一覧</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <div class="flex flex-col flex-1 w-full">
      <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
          <h2 class="my-6 text-2xl font-semibold text-gray-700 ">企業一覧</h2>
          <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 ">掲載企業一覧</h2>
            <a href="http://localhost:8080/admin/boozer_index_countstudents.php">
              人数通知メールを各企業に送る
            </a>
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                    <th class="px-4 py-3">更新日時</th>
                    <th class="px-4 py-3">企業名</th>
                    <th class="px-4 py-3">掲載期間</th>
                    <th class="px-4 py-3">登録状態</th>
                    <th class="px-4 py-3">申請人数</th>
                    <th class="px-4 py-3">操作</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y">
                  <?php foreach ($agents1 as $key => $agent) { ?>
                    <tr class="text-gray-700">
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?= $agent["updated_at"] ?></p>
                      </td>
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?= $agent["service_name"] ?></p>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?= $agent["started_at"] ?> ~ <?= $agent["ended_at"] ?>
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                          <!-- 色の設定はクラスの付加でjqueryで行う 登録無効（拒否）-->
                          登録完了
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?php
                        $found = false;
                        for ($i = 0; $i < count($agent_count); $i++) {
                          if ($agent_count[$i]["client_id"] == $agent["client_id"]) {
                            print_r($agent_count[$i]["sum"] . "人");
                            $found = true;
                            break;
                          }
                        }
                        if (!$found) {
                          print_r("0人");
                        } ?>
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" data=<?= $agent["client_id"] ?>>
                            <a href="http://localhost:8080/agent/agent_info/agent_disp.php?id=<?= $agent["client_id"] ?>&exist=1">詳細</a>
                          </button>
                            <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" onclick="hideUser(this)">
                            <a href="http://localhost:8080/admin/delete.php?id=<?= $agent["client_id"] ?>">削除</a>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto my-6">
              <h2 class="my-6 text-2xl font-semibold text-gray-700 ">掲載終了企業一覧</h2>
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                    <th class="px-4 py-3">更新日時</th>
                    <th class="px-4 py-3">企業名</th>
                    <th class="px-4 py-3">掲載期間</th>
                    <th class="px-4 py-3">登録状態</th>
                    <th class="px-4 py-3">申請人数</th>
                    <th class="px-4 py-3">操作</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y">
                  <?php foreach ($agents2 as $key => $agent) { ?>
                    <tr class="text-gray-700">
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?= $agent["updated_at"] ?></p>
                      </td>
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?= $agent["service_name"] ?></p>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?= $agent["started_at"] ?> ~ <?= $agent["ended_at"] ?>
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                          <!-- 色の設定はクラスの付加でjqueryで行う 登録無効（拒否）-->
                          登録完了
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?php
                        $found = false;
                        for ($i = 0; $i < count($agent_count); $i++) {
                          if ($agent_count[$i]["client_id"] == $agent["client_id"]) {
                            print_r($agent_count[$i]["sum"] . "人");
                            $found = true;
                            break;
                          }
                        }
                        if (!$found) {
                          print_r("0人");
                        } ?>
                      </td>
                      <td class="px-4 py-3" data-id="<?= $agent["client_id"] ?>">
                        <div class="flex items-center space-x-4 text-sm">
                          <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                            <a href="http://localhost:8080/agent/agent_info/agent_disp.php?id=<?= $agent["client_id"] ?>&exist=0">詳細</a>
                          </button>
                          <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" onclick="hideUser(this)">
                            <a href="http://localhost:8080/admin/delete.php?id=<?= $agent["client_id"] ?>">削除</a>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
<script>

function hideUser(button) {
  const tr = $(button).closest('tr');
  const id = tr.attr('data-id');
  
  if (confirm('本当に削除しますか？')) {
    $.ajax({
      url: 'http://localhost:8080/admin/delete.php',
      type: 'POST',
      data: { id: id },
      success: function(data) {
        console.log(data);
        tr.addClass('hidden');
      },
      error: function(xhr) {
        console.error(xhr);
      }
    });
  }
}
</script>
</html>

