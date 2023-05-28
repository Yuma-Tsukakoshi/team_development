<?php
session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/invalid_count.php');
require_once(dirname(__FILE__) . '/invalid_exam_count.php');

if (isset($_SESSION['sort'])) {
  $users = $_SESSION['sort'];
  unset($_SESSION['sort']);
}
elseif(isset($_SESSION['month'])) {
  $users = $_SESSION['month'];
  unset($_SESSION['month']);
}
else{
$pdo = Database::get();
$users = $pdo->query("SELECT * FROM users WHERE is_valid=true ORDER BY updated_at DESC")->fetchAll(PDO::FETCH_ASSOC);
}


// 削除成功時のメッセージ
if (isset($_GET['message']) && $_GET['message'] === 'deleted') {
  $message = "削除しました。";
}

//月ごとの絞り込み
$year='<option value=""></option>';
$month='<option value=""></option>';
$now=date('Y');
for ($i=2022; $i <= $now; $i++) {
  $year .= '<option value="'.$i.'">'.$i.'年</option>';
}
for ($j=1; $j <= 12; $j++) {
  if($j<10){
    $month .= '<option value="'.'0'.$j.'">'.$j.'月</option>';
  }else{
    $month .= '<option value="'.$j.'">'.$j.'月</option>';
  }
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
  <link rel="stylesheet" href="../user/assets/styles/boozer.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/DeuxHuitHuit/quicksearch/dist/jquery.quicksearch.min.js" defer></script>
  <script src="../user/assets/js/jquery.quicksearch.min.js" defer></script>
  <script src="../user/assets/js/student_filter.js" defer></script>
  <script src="../user/assets/js/student_sort.js" defer></script>
  <script src="../user/assets/js/student_month_search.js" defer></script>  
  
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
            <a class="logout inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-blue-500" href="../admin/boozer_auth/boozer_logout.php">
              <span class="ml-4">ログアウト</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="./boozer_index.php">
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
              <label class="block text-gray-700 font-bold mb-2" for="cleint">月ごと:</label>
            
              <select id="year" name="year" class="appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?=$year?></select>
              <select id="month" name="month" class="appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?=$month?></select>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2" id="search_btn">検索</button>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-bold mb-2" for="name">絞り込み検索 :</label>
              <input class="appearance-none border rounded  py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="keyword" type="text" placeholder="名前を入力してください">
            </div>
          </div>

          <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr data-id="<?= $user['id'] ?>" class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                    <th class="px-4 py-3">更新日時</th>
                    <th class="px-4 py-3">氏名</th>
                    <th class="px-4 py-3">フリガナ</th>
                    <th class="px-4 py-3">大学</th>
                    <th class="px-4 py-3">学部</th>
                    <th class="px-4 py-3">卒業年</th>
                    <th class="px-4 py-3">操作</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y" id="student">

                  <?php foreach ($users as $key => $user) {
                    if (isset($user['id'])) { ?>
                      <tr class="text-gray-700"><?php if (isset($user['deleted'])) echo 'data-deleted'; ?>
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
                        <td class="px-4 py-3">
                          <div class="flex items-center space-x-4 text-sm">
                            <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" data=<?= $user["id"] ?>>
                              <a href="http://localhost:8080/user/user_info/user_disp.php?id=<?= $user["id"] ?>">詳細</a>
                            </button>
                            <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray" aria-label="Edit" onclick="hideUser(this)">
                              <a href="http://localhost:8080/user/user_info/delete_user.php?id=<?= $user["id"] ?>">削除</a>
                            </button>
                          </div>
                        </td>
                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script>
  function hideUser(button) {
    const tr = $(button).closest('tr');
    const id = tr.attr('data-id');

    if (confirm('本当に削除しますか？')) {
      tr.addClass('hidden');
      $.ajax({
        url: 'http://localhost:8080/user/user_info/delete_user.php',
        type: 'POST',
        data: {
          id: id
        },
        success: function(data) {
          console.log(data);
        },
        error: function(xhr) {
          console.error(xhr);
        }
      });
    }
  }
  </script>
</body>




</html>
