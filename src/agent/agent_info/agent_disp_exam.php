<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_count.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_exam_count.php');


$pdo = Database::get();
$sql_1 = "SELECT * FROM clients WHERE client_id = :id ";
$stmt1 = $pdo->prepare($sql_1);
$stmt1->bindValue(":id", $_REQUEST["id"]);
$stmt1->execute();
$agent = $stmt1->fetch();
$sql_2 = "SELECT * FROM label_client_relation INNER JOIN labels ON label_client_relation.label_id = labels.label_id WHERE label_client_relation.client_id = :id ";
$stmt2 = $pdo->prepare($sql_2);
$stmt2->bindValue(":id", $_REQUEST["id"]);
$stmt2->execute();
$labels = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$sql_3 = "SELECT * FROM managers WHERE client_id = :id ";
$stmt3 = $pdo->prepare($sql_3);
$stmt3->bindValue(":id", $_REQUEST["id"]);
$stmt3->execute();
$manager = $stmt3->fetch();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../vendor/tailwind/tailwind.output.css">
  <link rel="stylesheet" href="../../admin/admin.css">
  <link rel="stylesheet" href="../../user/assets/styles/badge.css">
  <script src="../../user/assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="../../user/assets/js/agent_exam_valid.js" defer></script>
  <script src="../../user/assets/js/agent_exam_invalid.js" defer></script>
  <title>boozer申請企業詳細</title>
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
            <div class="notifier new">
              <div class="badge num"><?= $exam[0]['COUNT(*)'] ?></div>
            </div>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="http://localhost:8080/admin/boozer_agent_exam.php">
              <span class="ml-4">企業申請一覧</span>
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
        <h1 class="my-6 text-2xl font-semibold text-gray-700 text-center"><?= $agent["service_name"] ?> 企業詳細</h1>
        <div class="my-8 flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  申請企業
                </th>
                <th scope="col" class="px-6 py-3 text-left text-lg font-medium uppercase tracking-wider">
                  企業申請判定
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["service_name"] ?>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?php
                    if ($agent["exist"] == 0) {
                    ?>
                    <div class="flex  justify-between">
                        <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center">申請中</p>
                        <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center">企業申請:
                          <form id="emailForm" action="mail.php" method="post">
                            <input type="hidden" name="mail" value="<?= $manager["mail"] ?>">
                            <span id="valid_exam_btn" class="edit_btn" data="1" client="<?= (string)$agent["client_id"] ?>">
                              <a href="../agent_insert_mail.php" onclick="document.getElementById('emailForm').submit();">承認</a>
                            </span> 
                          </form>
                        </p>
                        <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center ">無効申請 : <p id="invalid_exam_btn" class="edit_btn" data="2" client=' . (string)$agent["client_id"] . '>拒否</p>
                      </div>
                    <?php }
                    elseif ($agent["exist"] == 1) {
                      print_r("申請承認");
                    } elseif ($agent["exist"] == 2) {
                      print_r("申請拒否");
                    } ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  企業情報
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
                    企業名
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["agent_name"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    サービス名
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["service_name"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    掲載期間
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["started_at"] ?> ~ <?= $agent["ended_at"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    キャッチコピー
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["catchphrase"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    おすすめ<br>ポイント1
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["recommend_point1"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    おすすめ<br>ポイント2
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["recommend_point2"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    おすすめ<br>ポイント3
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $agent["recommend_point3"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    企業ロゴ
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex-shrink-0 h-10 w-10">
                    <img class="h-9 w-9" src="<?= $agent["logo_img"] ?>" alt="">
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="my-8 flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  担当者情報
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
                    担当者名
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $manager["manager"] ?>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    部署
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-ms font-medium text-gray-900">
                    <?= $manager["depart"] ?>
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

                      <?= $manager["mail"] ?>
                      <button type="submit" class="text-blue-500 underline">メールを送る</button>

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
                    <?= $manager["phone"] ?>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="my-8 flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  ラベル情報
                </th>
                <th scope="col" class="px-6 py-3 text-left text-lg font-medium uppercase tracking-wider">
                  データ
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php foreach ($labels as $key => $label) { ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      ラベル<?= $key + 1 ?>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <?= $label["label_name"] ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</body>

</html>
