<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');
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
  <script src="../../user/assets/js/input.js" defer></script>
  <title>boozer企業編集</title>
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
              <span class="ml-4">企業一覧に戻る</span>
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
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
              <span class="ml-4">無効申請一覧</span>
              <!-- 無効申請で絞り込みする -->
            </a>
          </li>
        </ul>
      </div>
    </aside>


    <div class="flex flex-col flex-1 w-full">
      <main class="h-full pb-16 overflow-y-auto">
        <h1 class="my-6 text-2xl font-semibold text-gray-700 text-center"><?= $agent["service_name"] ?> 企業編集</h1>
        <p class="my-6 text-3xl font-semibold text-gray-700 text-center ">掲載状況 : 掲載中</p>
        <!-- 掲載状況期間によって色で示す 掲載停止か掲載中-->
        <form action="http://localhost:8080/agent/agent_info/agent_edit_check or done.php" method="POST" enctype="multipart/form-data">
          <!-- 編集のcheckって何の役割？メールアドレスとか同じ情報登録sレ輝とかでもそれって新規登録とかじゃない？
        メールの正規表現とか -->
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
                      <input type="text" name="agent_name" required value="<?= $agent["agent_name"] ?>" class="required" placeholder="企業名を入力">
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
                      <input type="text" name="service_name" required value="<?= $agent["service_name"] ?>" class="required" placeholder="サービス名を入力">
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
                      <input type="date" name="started_at" required value="<?= $agent["started_at"] ?>" class="required"> ~ <input type="date" name="ended_at" required value="<?= $agent["ended_at"] ?>" class="required">
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
                      <input type="text" name="catchphrase" required value="<?= $agent["catchphrase"] ?>" class="required" placeholder="キャッチコピーを入力">
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
                      <input type="text" name="recommend_point1" required value="<?= $agent["recommend_point1"] ?>" class="required" placeholder="おすすめポイントを入力">
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
                      <input type="text" name="recommend_point2" required value="<?= $agent["recommend_point2"] ?>" class="required" placeholder="おすすめポイントを入力">
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
                      <input type="text" name="recommend_point3" required value="<?= $agent["recommend_point3"] ?>" class="required" placeholder="おすすめポイントを入力">
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
                      <input type="url" name="recommend_point1" required value="<?= $agent["logo_img"] ?>" class="required" placeholder="画像のリンクを入力">
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
                      <input type="text" name="manager" required value="<?= $manager["manager"] ?>" class="required" placeholder="担当者名を入力">
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
                      <input type="text" name="depart" required value="<?= $manager["depart"] ?>" class="required" placeholder="部署を入力">
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
                      <input type="email" name="mail" required value="<?= $manager["mail"] ?>" class="required" placeholder="メールアドレスを入力">
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
                      <input type="tel" name="phone" required value="<?= $manager["phone"] ?>" class="required" placeholder="電話番号を入力">
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
                        <input type="text" name="labels[]" class="required" required placeholder="ラベル名を入力" value="<?= $label["label_name"] ?>">
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <button type="submit" class="btn submit">更新</button>
        </form>
      </main>
    </div>
  </div>

  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.required'))
    inputDoms.forEach(inputDom => {
      inputDom.addEventListener('input', event => {
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        submitButton.disabled = !isFilled
      })
    });
  </script>

</body>

</html>
