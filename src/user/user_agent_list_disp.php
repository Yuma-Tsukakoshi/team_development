<?php

session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');

if (isset($_SESSION['clients'])) {
  $count = count($_SESSION['clients']);
  $clients = $_SESSION['clients'];
}


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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../user/assets/styles/badge.css
  ">
  <link rel="stylesheet" href="./assets/styles/search.css">
  <link rel="stylesheet" href="./assets/styles/header.css">
  <link rel="stylesheet" href="./assets/styles/modal.css">
  <link rel="stylesheet" href="./assets/styles/form.css">
  <link rel="stylesheet" href="assets/styles/searchdetail.css">
  <title>エージェント詳細一覧</title>
</head>

<body>
  <header>
    <div class="header_wrapper">
      <div class="header_upper">
        <div class="craft_logo">CRAFT</div>
        <div class="boozer_logo"><img src="../user/assets/img/boozer_logo_white.png" alt="boozer Inc."></div>
      </div>
  </header>
  <section class="search">
    <div class="title-wrapper">
      <h1 class="search-title">SEARCH</h1>
      <span class="search-title-jpn">-エージェント検索-</span>
      <div class="search-title-border"></div>
    </div>
    <div class="cart relative">
      <? if (isset($clients)) {
        foreach ($clients as $client) { ?>
          <input type="hidden" class="input" name="agents[]" value="<?= $client['agent'] ?>">
        <? }
      } ?>
      <div class="notifier new">
        <div class="cart-badge badge num">
          <?php if (isset($count)) { ?>
            <?= $count ?>
          <?php } else{?>
            0
          <?php }?>
        </div>
        <div class="search-title-cart-border">
          <a href="./user_cartlook.php">
            <img class="search-title-cart" src="../user/assets/img/728.png" alt="shopping_cart">
          </a>
        </div>
      </div>
    </div>
  </section>
  <div class="overlay" id="js-overlay"></div>

  <div id="modal-content" class="modal-content">
    <div class="check-message">
      <div class="check-circle">
        <div class="check"></div>
      </div>
      <div class="message">カートに追加しました</div>
    </div>
    <div class="modal-cart">
      <div class="return-link modal-button">
        <a href="./user_cartlook.php">
          <p class="link-message">カート一覧へ</p>
        </a>
      </div>
      <div class="maru">
        <span class="maru-num">
          <?php if (isset($count)) { ?>
            <?= $count ?>
          <?php }else{ ?>
            0
          <?php }?>
        </span>
      </div>
    </div>
  </div>

  <main>
    <section>
      <div class="wrapper">
        <div class="inner-top">
          <div class="grid grid-cols-2">
            <div class="company-info">
              <img class="company-info-building-img" src="./assets/img/1225.png" alt="株式会社っぽい写真">
              <h2 class="company-info-name"><?= $agent["service_name"] ?></h2>
              <p class="company-info-company-number">掲載数:<span><?= $agent["publication_num"] ?>社</span></p>
              <!-- <p>キャッチコピー: <span>面接対策しっかりやってます</span></p> -->
              <!-- ここのキャッチコピーとは？？ -->
              <p class="company-info-assignee">担当者: <span><?= $manager["manager"] ?></span></p>
              <p class="company-info-hp transition-link">ホームぺージ：<a href="<?= $agent["homepage"] ?>" target="_blank" class="company-info-hp-link">リンクはこちらから</a></p>
            </div>
            <div class="company-logo">
              <img src="<?= $agent["logo_img"] ?>" alt="企業ロゴ">
            </div>
          </div>

          <div class="label ">
            <?php foreach ($labels as $label) { ?>
              <span class="label-content">
                <?= $label["label_name"] ?>
              </span>
              &nbsp;
            <?php } ?>
          </div>
          <div class="recommend-wrapper">
            <div class="recommend-content">
              <ul>
                <?php for ($i = 1; $i <= 3; $i++) { ?>
                  <div class="recommend-sec">
                    <img class="ic-fire" src="./assets/img/ic050.png" alt="fire">
                    <li class="merit"><?= $agent["recommend_point$i"] ?></li>
                  </div>
                <?php } ?>
              </ul>
            </div>
          </div>
          <input type="hidden" value="<?= $_REQUEST['client_id'] ?> " class="client_id">
          <button class="btn-big cyan orange add-button" value="<?=$_REQUEST['id']?>">カートに追加する</button>
        </div>
        <div class="inner-bottom-line"></div>
        <div class="inner-bottom">
          <h2 class="opinion-title">口コミ</h2>
          <img class="opinion-img" src="./assets/img/278.png" alt="口コミの画像">
          <div class="opinion-bubble">
            <p class="opinion-bubble-text1">手厚いサポートのおかけで内定が決まりました。<br> (2023年春卒 女性)</p>
            <p class="opinion-bubble-text2">目指したい業種があまり明確でない人におすすめのエージェント会社だと思います。<br> (2022年卒男性)</p>
            <p class="opinion-bubble-text3">コロナ禍に対応したサポートにより、例年の就活と大きく変わることなく就活に取り組むことができました。<br> (2023卒男性)</p>
          </div>
          <div class="opinion-bubble-triangle"></div>
          <button class="btn-big blue"><a href="http://localhost:8080/user/user_agent_list.php">検索画面に戻る</a></button>
        </div>

      </div>
    </section>
  </main>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $(function() {
      //ボタン灰色
      const inputs = $('.input').each(function(index, element) {
        $index = element.value
        $id=$('.add-button').val()
        if(Number($index)==Number($id)){
          $('.add-button').prop("disabled", true);
          $('.add-button').removeClass("orange");
          $('.add-button').removeClass("cyan");
          $('.add-button').css('background-color', 'gray');
        }
      })
     //スクロールすると上部に固定させるための設定を関数でまとめる
     function FixedAnime() {
        var headerH = $('.search').outerHeight(true);
        var scroll = $(window).scrollTop();
        if (scroll + 30 >= headerH) { //headerの高さ以上になったら
          $('.search').addClass('move'); //fixedというクラス名を付与
        } else { //それ以外は
          $('.search').removeClass('move'); //fixedというクラス名を除去
        }
      }
      // 画面をスクロールをしたら動かしたい場合の記述
      $(window).scroll(function() {
        FixedAnime(); /* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
      });
      // ページが読み込まれたらすぐに動かしたい場合の記述
      $(window).on('load', function() {
        FixedAnime(); /* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
      });

     $('.add-button').on('click', function(event) {
        $index = this.value
        console.log($index)
        $.ajax({
          type: "POST",
          url: "./user_cartin.php",
          data: {
            id: $('.client_id').val(),
            client_id: $index,
          },
          dataType: "json",
          scriptCharset: 'utf-8'
        }).done(function(data) {
          $('.modal-content').fadeIn();
          $('.overlay').fadeIn();
          // クリックイベント全てに対しての処理
          $(document).on('click touchend', function(event) {
            // 表示したポップアップ以外の部分をクリックしたとき
            if (!$(event.target).closest('.modal-content').length) {
              $('.modal-content').fadeOut();
              $('.overlay').fadeOut();
            }
          });
          console.log(data);
  
          $('.cart-badge').text(data)
          $('.add-button').prop("disabled", true);
          $('.add-button').removeClass("orange");
          $('.add-button').removeClass("cyan");
          $('.add-button').css('background-color', 'gray');
          $('.maru-num').text(data)
          //背景グレーとか調整する
        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
          alert(errorThrown);
        });
      })
    })
  </script>
</body>

</html>
