<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');
require_once(dirname(__FILE__) . '/../../admin/invalid_count.php');

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
  <title>企業登録</title>
</head>

<body>
  <div class="flex h-screen bg-gray-50" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <!-- side banner 入らない？ -->
    <!--<aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-slate-500 md:block">
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
    </aside>-->


    <div class="flex flex-col flex-1 w-full">
      <main class="h-full pb-16 overflow-y-auto">
        <h1 class="my-6 text-2xl font-semibold text-gray-700 text-center">企業登録</h1>
        
        <form action="http://localhost:8080/agent/agent_info/agent_insert.done.php" method="POST" enctype="multipart/form-data">
          <!-- メールの正規表現とか -->
          <div class="my-8 flex justify-center">
            <table class="w-full mx-8 max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
              <thead class="bg-blue-500 text-white">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-lg  font-medium uppercase tracking-wider">
                    ログイン情報
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
                        メールアドレス
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                    <input type="mail" name="login_mail" required class="required" placeholder="メールアドレスを入力">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        パスワード
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <input type="password" name="password" required class="required" placeholder="パスワードを入力">
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
                      <input type="text" name="agent_name" required class="required" placeholder="企業名を入力">
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
                      <input type="text" name="service_name" required class="required" placeholder="サービス名を入力">
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
                      <input type="date" name="started_at" required  class="required"> ~ <input type="date" name="ended_at" required  >
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
                      <input type="text" name="catchphrase" required  class="required" placeholder="キャッチコピーを入力">
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
                      <input type="text" name="recommend_point1" required class="required" placeholder="おすすめポイントを入力">
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
                      <input type="text" name="recommend_point2" required  class="required" placeholder="おすすめポイントを入力">
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
                      <input type="text" name="recommend_point3" required class="required" placeholder="おすすめポイントを入力">
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
                      <input type="url" name="logo_img" required class="required input-img" placeholder="画像のリンクを入力">
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
                      <input type="text" name="manager" required class="required" placeholder="担当者名を入力">
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
                      <input type="text" name="depart" required class="required" placeholder="部署を入力">
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
                      <input type="email" name="mail" required class="required" placeholder="メールアドレスを入力">
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
                      <input type="tel" name="phone" required class="required" placeholder="電話番号を入力">
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
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        学生の専攻
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        <input type="radio" name="subject[]" id="label" value="1" class="form-control" required />理系
                        <input type="radio" name="subject[]" id="label" value="2" class="form-control" required />文系
                        <input type="radio" name="subject[]" id="label" value="0" class="form-control" required />どちらも
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        面談方法
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        <input type="checkbox" name="contact[]" id="label" value="3" class="form-control" />メール
                        <input type="checkbox" name="contact[]" id="label" value="4" class="form-control" />電話
                        <input type="checkbox" name="contact[]" id="label" value="5" class="form-control"  />オフライン
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        対応可能エリア(オフライン)
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-ms font-medium text-gray-900">
                        <input type="checkbox" name="place[]" id="label" value="6" class="form-control"  />東京
                        <input type="checkbox" name="place[]" id="label" value="7" class="form-control"  />大阪
                        <input type="checkbox" name="place[]" id="label" value="8" class="form-control"  />名古屋
                        <input type="checkbox" name="place[]" id="label" value="9" class="form-control"  />福岡
                      </div>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>

          <div class="btn_wrapper">
            <button type="submit" class="btn submit update_btn">登録</button>
          </div>
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
