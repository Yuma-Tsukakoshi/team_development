<?php
session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/invalid_count.php');

$pdo = Database::get();
$users = $pdo->query("SELECT * FROM users ORDER BY updated_at DESC")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['sort'])) {
  $users = $_SESSION['sort'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.output.css">
  <link rel="stylesheet" href="../user/assets/styles/badge.css">
  <script src="../user/assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/gh/DeuxHuitHuit/quicksearch/dist/jquery.quicksearch.min.js" defer></script>
  <script src="../user/assets/js/jquery.quicksearch.min.js" defer></script>
  <script src="../user/assets/js/student_filter.js" defer></script>
  <script src="../user/assets/js/student_sort.js" defer></script>
  <title>boozer学生一覧</title>
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
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="./boozer_index.php">
              <span class="ml-4">企業一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
              <span class="ml-4">企業新規登録</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="#">
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
          <h2 class="my-6 text-2xl font-semibold text-gray-700 ">学生一覧</h2>

          <div class="flex justify-end  w-full">
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="name">絞り込み検索 :</label>
              <input class="appearance-none border rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="keyword" type="text" placeholder="名前を入力してください">
            </div>
            <div>
              <label for="sort-by" class=" block text-gray-700 font-bold mb-2 mr-2">学生の並び替え：</label>
              <div class="relative inline-flex">
                <select id="sort-by" name="sort-by" class="appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value=""></option>
                  <option value="ascending">ア行から</option>
                  <option value="descending">ワ行から</option>
                </select>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" id="sort_btn">並び替え</button>
              </div>
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
                          承認済
                        </span>
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" data=<?= $user["id"] ?>>
                            <a href="http://localhost:8080/user/user_info/user_disp.php?id=<?= $user["id"] ?>">詳細</a>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t sm:grid-cols-9">
              <span class="flex items-center col-span-3">
                Showing 1-10 of 50
              </span>
              <span class="col-span-2"></span>
              <!-- Pagination -->
              <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                  <ul class="inline-flex items-center">
                    <li>
                      <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                          <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1 <!-- ■１ ■２ ■3 ... みたいな -->
                      </button>
                    </li>
                    <li>
                      <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                        <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                          <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </li>
                  </ul>
                </nav>
              </span>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>

</html>
