<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_count.php');

$pdo = Database::get();
$sql = "SELECT * FROM users INNER JOIN user_register_client as relation  ON relation.user_id = users.id WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$user = $stmt->fetch();
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
  <title>学生情報編集</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <h1 class="my-6 text-2xl font-semibold text-gray-700 text-center">学生情報詳細 <?= $user["name"] ?> 様</h1>
        <form action="http://localhost:8080/user/user_info/user_edit_check.php?id=<?= $user["id"] ?>" method="POST" enctype="multipart/form-data">
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
                      氏名
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <input type="text" name="name" required value="<?= $user["name"] ?>" class="required" placeholder="氏名を入力">
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
                      <input type="text" name="hurigana" required value="<?= $user["hurigana"] ?>" class="required" placeholder="フリガナを入力">
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
                      <input type="text" name="sex" required value="<?= $user["sex"] ?>" class="required" placeholder="性別を入力">
                      <!-- ラジオボタンに変更 -->
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
                      <input type="date" name="birthday" required value="<?= $user["birthday"] ?>" class="required" placeholder="生年月日を入力">
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
                      <input type="email" name="mail" required value="<?= $user["mail"] ?>" class="required" placeholder="メールアドレスを入力">
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
                      <input type="tel" name="phone" required value="<?= $user["phone"] ?>" class="required" placeholder="電話番号を入力">
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
                      <input type="text" name="prefecture" required value="<?= $user["prefecture"] ?>" class="required" placeholder="所在地を入力">
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
                      <input type="text" name="college" required value="<?= $user["college"] ?>" class="required" placeholder="大学名を入力">
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
                      <input type="text" name="faculty" required value="<?= $user["faculty"] ?>" class="required" placeholder="学部名を入力">
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
                      <input type="text" name="department" required value="<?= $user["department"] ?>" class="required" placeholder="学科名を入力">
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
                      <input type="text" name="division" required value="<?= $user["division"] ?>" class="required" placeholder="文理を選択">
                      <!-- ラジオボタンに変更する -->
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
                      <input type="text" name="grad_year" required value="<?= $user["grad_year"] ?>" class="required" placeholder="卒業年を入力">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <input type="hidden" name="id" value="<?= $user["id"] ?>">
          <div class="btn_wrapper">
            <button type="submit" class="btn submit update_btn">更新</button>
          </div>
          <div class="btn_wrapper">
            <!-- 削除ボタン -->
            <div class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
              <button type="button" id="delete_btn">非表示にする</button>
            </div>
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
