<?php

session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');

if (isset($_SESSION['clients'])) {
  $count = count($_SESSION['clients']);
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
  <link rel="stylesheet" href="./assets/styles/header.css">
  <link rel="stylesheet" href="./assets/styles/search.css">
  <link rel="stylesheet" href="assets/styles/searchdetail.css">
  <title>エージェント詳細一覧</title>
</head>

<body>
  <?php include(dirname(__FILE__) . '/../components/header.php'); ?>
  <section class="search">
    <div class="search-head">
      <h1 class="search-title">DETAIL</h1>
      <span class="search-title-jpn">-エージェント詳細-</span>
      <div class="search-title-border"></div>
    </div>
    <div>
      <img class="search-title-cart" src="./assets/img/728.png" alt="shopping_cart">
      <div class="search-title-cart-border"></div>
    </div>
  </section>

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
                <li class="merit"><?= $agent["recommend_point1"] ?></li>
                <li class="merit"><?= $agent["recommend_point2"] ?></li>
                <li class="merit"><?= $agent["recommend_point3"] ?></li>
              </ul>
            </div>
          </div>
          <button class="btn-big cyan">カートに追加する</button>
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
</body>

</html>
