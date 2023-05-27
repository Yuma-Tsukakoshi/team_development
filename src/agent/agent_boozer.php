<?php
session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/agent_invalid_count.php');

if (isset($_SESSION['agent_sort'])) {
  $users = $_SESSION['agent_sort'];
}

$pdo = Database::get();
$sql = "SELECT * FROM users INNER JOIN user_register_client AS r ON users.id = r.user_id WHERE r.client_id = :id AND r.is_valid=1 ORDER BY updated_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_SESSION["id"]);

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$name = $_SESSION['name'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./../vendor/tailwind/tailwind.output.css">
  <link rel="stylesheet" href="../user/assets/styles/badge.css">
  <link rel="stylesheet" href="../user/assets/styles/boozer.css">
  <script src="../user/assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/gh/DeuxHuitHuit/quicksearch/dist/jquery.quicksearch.min.js" defer></script>
  <script src="../user/assets/js/jquery.quicksearch.min.js" defer></script>
  <script src="../user/assets/js/student_filter.js" defer></script>
  <script src="../user/assets/js/agent_student_sort.js" defer></script>
  <title>エージェント学生一覧</title>
</head>

<body>
  <div class="flex h-screen bg-gray-50" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-slate-500 md:block">
      <div class="py-4 text-gray-500">
        <a class="ml-6 text-lg font-bold text-gray-800 " href="#">
          SideBanner
        </a>
        <ul class="mt-6">
        <li class="relative px-6 py-3">
            <a class="logout inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-blue-500" href="../agent/agent_auth/agent_logout.php">
              <span class="ml-4">ログアウト</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
              <span class="ml-4">学生一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <div class="notifier new">
              <div class="badge num"><?= $count[0] ?></div>
            </div>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="./agent_invalid_student.php">
              <span class="ml-4">無効申請一覧</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <div class="flex flex-col flex-1 w-full">
      <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
          <h2 class="my-6 text-2xl font-semibold text-gray-700 ">ようこそ！<?= $name ?> 様</h2>
          <h2 class="my-6 text-2xl font-semibold text-gray-700 ">学生一覧</h2>

          <div class="flex justify-end  w-full">
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="name">絞り込み検索 :</label>
              <input class="appearance-none border rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="keyword" type="text" placeholder="名前を入力してください">
            </div>
          </div>

          <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                    <th class="px-4 py-3">更新日時</th>
                    <th class="px-4 py-3">氏名</th>
                    <th class="px-4 py-3">フリガナ</th>
                    <th class="px-4 py-3">大学</th>
                    <th class="px-4 py-3">学部</th>
                    <th class="px-4 py-3">卒業年</th>
                    <th class="px-4 py-3">無効申請</th>
                    <th class="px-4 py-3">操作</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y" id="student">
                  <?php foreach ($users as $key => $user) { ?>
                    <tr class="text-gray-700">
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?= $user["updated_at"] ?></p>
                      </td>
                      <td class="px-4 py-3">
                        <p class="font-semibold items-center text-sm"><?= $user["name"] ?></p>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?= $user["hurigana"] ?>
                      </td>
                      <td class="px-4 py-3 text-sm hidden">
                        <?= mb_convert_kana($user["hurigana"], "c"); ?>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?= $user["college"] ?>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?= $user["faculty"] ?>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <?= $user["grad_year"] ?>
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                          <!-- 色の設定はクラスの付加でjqueryで行う 無効申請-->
                          <?php
                          if ($user["valid"] == 0) {
                            print_r("申請なし");
                          } elseif ($user["valid"] == 1) {
                            print_r("申請中");
                          } elseif ($user["valid"] == 2) {
                            print_r("申請承認");
                          } elseif ($user["valid"] == 3) {
                            print_r("申請拒否");
                      }
                          ?>
                        </span>
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" data=<?= $user["user_id"] ?>>
                            <a href="http://localhost:8080/user/user_info/boozer_user_disp.php?id=<?= $user["user_id"] ?>">詳細</a>
                          </button>
                        </div>
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" data=<?= $user["user_id"] ?> >
                            <a href="http://localhost:8080/user/user_info/agent_delete_user.php?user_id=<?= $user["user_id"] ?>&client_id=<?= $user["client_id"] ?>">削除</a>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

          <!--csvダウンロードボタン-->
          <div class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-7 w-10">
            <a href="./agent_csv.php">
              <button>csvダウンロード</button>
            </a>
          </div>
        </div>
      </main>
    </div>

    <script>
      $(document).ready(function() {
        $('.delete-link').click(function(e) {
          e.preventDefault();
          var userId = $(this).parent().data('userid');
          var clientId = $(this).parent().data('clientid');
          var confirmation = confirm("本当に削除しますか？");

          if (confirmation) {
            var deleteUrl = "http://localhost:8080/user/user_info/agent_delete_user.php?user_id=" + userId + "&client_id=" + clientId;
            window.location.href = deleteUrl;
          }
        });
      });
    </script>

  </div>
</body>

</html>
