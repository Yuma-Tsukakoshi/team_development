<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込み完了</title>
    <!-- スタイルシート読み込み -->
    <link rel="stylesheet" href="../assets/styles/common.css">
    <link rel="stylesheet" href="../assets/styles/cart.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./../../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../assets/styles/form.css">
  <link rel="stylesheet" href="../assets/styles/cart.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
  <header>
    <!-- <div class="header_wrapper">
      <div class="header_upper">
        <div class="craft_logo">CRAFT</div>
        <div class="boozer_logo"><img src="../user/assets/img/boozer_logo_white.png" alt="boozer Inc."></div>
      </div>
    </div>
  </header> -->
  <main>
  <div class="shadow-wrapper">
    <div class="phase-image">
      <div class="first-box">カート一覧</div>
      <div class="border-line"></div>
      <div class="second-box">申し込み<span>フォーム</span></div>
      <div class="border-line"></div>
      <div class="third-box">申し込み<span>確認</span></div>
      <div class="border-line"></div>
      <div class="fourth-box">完了</div>
      </div>
    </div>
    <div class="thanks-area">
      <div class="thanks-message-area">
      <div class="thanks-message">
        <div class="message-content m">申し込み<span>ありがとうございました！</span></div>
        <div class="message-content">確認のため、メールをご確認ください。</div>
        <div class="return-link thanks-link">
          <a href="http://localhost:8080/user/user_agent_list.php">検索ページに戻る</a>
        </div>
      </div>
    </div>
  </main>



</body>
<script>
  $('.first-box').css('background-color','#dcdcdc')
  $('.fourth-box').css('background-color','#0071bc')
  $('.fourth-box').toggleClass('active')


</script>

</html>