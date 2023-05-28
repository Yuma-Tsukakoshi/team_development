<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
require_once(dirname(__FILE__) . '/../../agent/agent_invalid_count.php');

$pdo = Database::get();
$sql = "SELECT * FROM users WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$user = $stmt->fetch();

$sql2 = "SELECT relation.valid FROM user_register_client as relation INNER JOIN clients ON relation.client_id = clients.client_id WHERE relation.user_id = :id AND relation.client_id= :client_id";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(":id", $_REQUEST["id"]);
$stmt2->bindValue(":client_id", $_SESSION["id"]);
$stmt2->execute();
$valid = $stmt2->fetch();

$sql3 = "SELECT service_name , reason.reason FROM clients INNER JOIN invalid_reason AS reason ON reason.client_id = clients.client_id WHERE clients.client_id=:id AND reason.user_id=:ui";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindValue(":ui", $_REQUEST["id"]);
$stmt3->bindValue(":id", $_SESSION["id"]);
$stmt3->execute();
$invalid_agents = $stmt3->fetch();
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
  <link rel="stylesheet" href="../assets/styles/boozer.css">
  <link rel="stylesheet" href="_user_disp.css">
  <script src="../assets/js/other_text.js" defer></script>
  <script src="../assets/js/jquery-3.6.1.min.js"></script>
  <title>エージェント学生情報詳細</title>
</head>

<body>
  <!-- modalの処理 -->
  <form action="http://localhost:8080/agent/agent_insert_reason.php?id=<?= $_GET["id"] ?>" method="POST">
    <div class="popup" id="js-popup">
      <div class="popup-inner">
        <div class="close-btn" id="js-close-btn"><i class="fas fa-times"></i></div>
        <div class="Form">
          <div class="Form-Item">
            <h2 class="block text-gray-700 font-bold mb-2 Form-Item-Label isMsg" for="reason">申請理由</h2>
            <div class="select-form">
              <label class="radio-input" for="reason1">
                <input type="radio" name="reason" id="reason1" value="メールアドレスがエラー" class="radio-button" required />メールアドレスがエラー
              </label>
              <label class="radio-input" for="reason2">
                <input type="radio" name="reason" id="reason2" value="登録内容に不備あり" class="radio-button" required />登録内容に不備あり
              </label>
              <label class="radio-input" for="reason3">
                <input type="radio" name="reason" id="reason3" value="同じ学生が重複している" class="radio-button" required />同じ学生が重複している
              </label>
              <label class="radio-input" for="reason4">
                <input type="radio" name="reason" id="reason4" value="other" class="radio-button" required />その他
              </label>
              <input type="text" name="reason_text" id="otherInput">
            </div>
          </div>
          <input type="submit" class="btn-big cyan valid_send_btn" value="送信する">
          <!-- Form-Btn -->
          <input type="hidden" name="client_id" value="<?= $_SESSION["id"] ?>">
        </div>
      </div>
      <div class="black-background" id="js-black-bg"></div>
    </div>
  </form>


  <div class="flex h-screen bg-gray-50" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <!-- side banner -->
    <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-slate-500 md:block">
      <div class="py-4 text-gray-500">
        <a class="ml-6 text-lg font-bold text-gray-800 " href="#">
          SideBanner
        </a>
        <ul class="mt-6">
          <li class="relative px-6 py-3">
            <a class="logout inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-blue-500" href="../../agent/agent_auth/agent_logout.php">
              <span class="ml-4">ログアウト</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="http://localhost:8080/agent/agent_boozer.php">
              <span class="ml-4">学生一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <div class="notifier new">
              <div class="badge num"><?= $count[0] ?></div>
            </div>
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="http://localhost:8080/agent/agent_invalid_student.php">
              <span class="ml-4">無効申請一覧</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <div class="flex flex-col flex-1 w-full">
      <main class="h-full pb-16 overflow-y-auto">
        <h1 class="my-6 text-2xl font-semibold text-gray-700 text-center">学生情報詳細 <?= $user["name"] ?> 様</h1>
        <div class="my-8 flex justify-center">
          <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                  無効申請判定
                </th>
                <th scope="col" class="px-6 py-3 text-left text-lg font-medium uppercase tracking-wider">
                  <?php
                  if ($valid[0] == 0) {
                    print_r("申請なし");
                  } elseif ($valid[0] == 1) {
                    print_r("申請中");
                  } elseif ($valid[0] == 2) {
                    print_r("申請承認");
                  } elseif ($valid[0] == 3) {
                    print_r("申請拒否");
                  }
                  ?>
                </th>
              </tr>
            </thead>
            <?php
            if ($valid[0] != 0) {
            ?>
              <tbody class="divide-y divide-gray-200">
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      無効申請理由
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-ms font-medium text-gray-900">
                      <?= $invalid_agents['reason'] ?>
                    </div>
                  </td>
                </tr>
              </tbody>
            <?php
            }
            ?>
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
        <div>
          <button>

          </button>
        </div>
        <?php
        if ($valid[0] == 0) {
          echo '<button class="form-open edit_btn" id="js-show-popup">無効申請する</button>';
        }
        ?>
      </main>
    </div>
  </div>
</body>
</body>
<script src="_user_disp.js"></script>

</html>
