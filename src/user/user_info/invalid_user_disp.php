<?php
session_start();
require_once(dirname(__FILE__) . '/../../dbconnect.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_count.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_exam_count.php');

$_SESSION["uid"] = $_GET["id"];

$pdo = Database::get();
$sql = "SELECT * FROM users WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$user = $stmt->fetch();

$sql2 = "SELECT clients.service_name, valid ,relation.client_id FROM user_register_client as relation INNER JOIN clients ON relation.client_id = clients.client_id WHERE user_id = :id";
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

// メール機能
$sql4 = "SELECT mail FROM managers WHERE client_id IN (SELECT client_id FROM user_register_client WHERE user_id = :id)";
$stmt4 = $pdo->prepare($sql4);
$stmt4->bindValue(":id", $_REQUEST["id"]);
$stmt4->execute();
$manager_mail = $stmt4->fetchAll(PDO::FETCH_COLUMN);

$headers = 'From: admin@mail' . "\r\n" .
'Reply-To: admin@mail' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

// 宛先と件名、メッセージをそれぞれ設定してメール送信関数を呼び出す
function send_email($to, $subject, $message, $headers) {
  if (mail($to, $subject, $message, $headers)) {
  } else {
    echo "メールの送信に失敗しました。\n";
    echo "エラー情報: " . error_get_last()['message'];
  }
}

// user宛のメール
$to_user= $user["mail"] ;
$subject_user = "【株式会社boozer】お申し込みありがとうございます";
$subject_user = "【株式会社boozer】お申し込みありがとうございます";
$message_user = "※このメールはシステムからの自動返信です\n\n";
$message_user .= "株式会社boozerでの新規登録ありがとうございました。\n\n";
$message_user .= "お申し込みいただいた企業から担当者よりご連絡いたしますので\n";
$message_user .= "今しばらくお待ちくださいませ。\n\n";

send_email($to_user, $subject_user, $message_user, $headers);

// manager宛のメール
$to_managers = $manager_mail;
$subject_client = "【株式会社boozer】学生登録のお知らせ";
$message_client = "お世話になっております。\n";
$message_client .= "株式会社boozerでございます。\n\n";
$message_client .= "CRAFTを通して学生より貴社の就活エージェントにお申込みいただいたことを通知いたします。詳しくはCRAFTよりご覧ください。\n\n";
$message_client .= "なお、営業時間は平日9時〜18時となっております。\n";
$message_client .= "時間外のお問い合わせは翌営業日にご連絡差し上げます。\n\n";
$message_client .= "ご理解・ご了承の程よろしくお願い致します。";

send_email($to_client, $subject_client, $message_client, $headers);


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
  <script src="../assets/js/jquery-3.6.1.min.js" defer></script>
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
            <a class="logout inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-blue-500" href="../admin/boozer_auth/boozer_logout.php">
              <span class="ml-4">ログアウト</span>
            </a>
          </li>

          <li class="relative px-6 py-3">
            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800" href="../../admin/boozer_index.php">
              <span class="ml-4">企業一覧</span>
            </a>
          </li>
          <li class="relative px-6 py-3">
            <div class="notifier new">
              <div class="badge num"><?= $exam[0]['COUNT(*)'] ?></div>
            </div>
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
                        echo '<div class="flex  justify-between">
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center ">申請中</p>
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center ">無効申請 : <p id="valid_btn" class="edit_btn" data="2" client=' . (string)$agent["client_id"] . '>承認</p></p>
          <p class="my-6 mx-8 text-3xl font-semibold text-gray-700 flex justify-center ">無効申請 : <p id="invalid_btn" class="edit_btn" data="3" client=' . (string)$agent["client_id"] . '>拒否</p></p>
        </div>';
                      } elseif ($agent["valid"] == 2) {
                        print_r("申請承認");
                      } elseif ($agent["valid"] == 3) {
                        print_r("申請拒否");
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
