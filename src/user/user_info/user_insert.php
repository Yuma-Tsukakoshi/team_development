<?php
require_once(dirname(__FILE__) . './../../dbconnect.php');

session_start();

$pdo = Database::get();
$idList = array();
$agentsAll = $_SESSION['clients'];
if (isset($agentsAll)) {
  foreach ($agentsAll as $agents) {
    $agent_id = $agents['agent'];
    $agent = $pdo->query("SELECT * FROM clients where client_id = $agent_id")->fetchAll(PDO::FETCH_ASSOC);
    array_push($idList, $agent[0]['agent_name']);
  }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込みフォーム</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./../../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../assets/styles/header.css">
  <link rel="stylesheet" href="../assets/styles/form.css">
  <link rel="stylesheet" href="../assets/styles/cart.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
  <header>
    <div class="header_wrapper">
      <div class="header_upper">
        <div class="craft_logo">CRAFT</div>
        <div class="boozer_logo"><img src="../user/assets/img/boozer_logo_white.png" alt="boozer Inc."></div>
      </div>
    </div>
  </header>
  <main>
    <div class="phase-image">
      <div class="first-box">カート一覧</div>
      <div class="border-line"></div>
      <div class="second-box">申し込み<span>フォーム</span></div>
      <div class="border-line"></div>
      <div class="third-box">申し込み<span>確認</span></div>
      <div class="border-line"></div>
      <div class="fourth-box">完了</div>
    </div>
    <form method="post" action="http://localhost:8080/user/user_info/user_insert.check.php"class="bg-white rounded-lg overflow-hidden shadow-lg user-form">
     
        <div class="text-2xl text-gray-800 font-bold mb-6">申し込みフォーム</div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="name">名前</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name"id="name" type="text" placeholder="山田 太郎" required>
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="hurigana">ふりがな</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="hurigana"id="hurigana" type="text" placeholder="やまだ たろう" required>
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="email">メールアドレス</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"name="email" id="email" type="email" placeholder="aaaa@gmail.com"pattern="^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$" title="メールアドレスを正しく入力してください" required>
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="phone">電話番号(ハイフンあり)</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="phone"id="phone" type="tel" placeholder="000-0000-0000" required pattern="\d{1,5}-\d{1,4}-\d{4,5}" title="電話番号は、市外局番からハイフン（-）を入れて記入してください。">
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="sex">性別</label>
          <div class="flex">
            <div class="radio-input">
              <input type="radio" name="sex" id="sex" value="女" class="radio-button" required />女性
            </div>
            <div class="radio-input">
              <input type="radio" name="sex" id="sex" value="男" class="radio-button" required />男性
            </div>
            <div class="radio-input">
              <input type="radio" name="sex" id="sex" value="その他" class="radio-button" required />その他
            </div>
          </div>
         
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="birthday">生年月日</label>
          <input type="date" name="birthday" id="birthday" class="form-control" required />
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="prefecture">住まいの都道府県</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="prefecture"id="prefecuture" type="text" placeholder="東京都" required>
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="college">大学名</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="college"id="college" type="text" placeholder="慶應義塾大学" required>
        </div>
        <div class="mb-4 flex">
          <div class="form-controll double-input">
            <label class="block text-gray-700 font-bold mb-2" for="faculty">学部</label>
            <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline " name="faculty"id="faculty" type="text" placeholder="法学部" required>
          </div>
          <div class="form-controll double-input">
            <label class="block text-gray-700 font-bold mb-2" for="department">学科</label>
            <input class="appearance-none border rounded  py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="department"id="department" type="text" placeholder="法律学科" required>
          </div>
        </div>
        <div class="mb-4 ">
            <label class="block text-gray-700 font-bold mb-2" for="division">文理</label>
            <div class="flex">
              <div class="radio-input">
                <input type="radio" value="文系" name="division" id="division" class="radio-button" required />文系
              </div>
              <div class="radio-input">
                <input type="radio" value="理系" name="division" id="division" class="radio-button" required />理系
              </div>
            </div>
        </div>
        <div class="mb-4 ">
          <label class="block text-gray-700 font-bold mb-2" for="grad_year">卒業年度</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="grad_year"id="grad_year" type="text" placeholder="2025" required>
        </div>
      </div>
      <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="company">申し込み企業一覧</label>
        <?php if ($idList != null) {
          foreach ($idList as $agent) { ?>
            <input name="company[]"  class="appearance-none border rounded  py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $agent ?>" required>
        <?php }
        } ?>
      </div>
      <div class="flex items-center justify-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline" type="submit">
            送信する
        </button>
      </div>
    </form>

    <!-- <form class="bg-white rounded-lg overflow-hidden shadow-lg">
      <div class="px-8 py-6">
        <div class="text-2xl text-gray-800 font-bold mb-6">お申し込みフォーム</div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="name">名前</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="山田 太郎">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="email">メールアドレス</label>
          <input class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="you@example.com">
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 font-bold mb-2" for="message">お問い合わせ内容</label>
          <textarea class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="message" placeholder="お問い合わせ内容を入力してください"></textarea>
        </div>
        <div class="flex items-center justify-center">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline" type="button">
            送信する
          </button>
        </div>
      </div>
    </form> -->
  </main>
  <script>
    $(function(){
      $('.first-box').css('background-color','#dcdcdc')
      $('.second-box').css('background-color','#ffff66')

    })
  </script>

</body>

</html>
