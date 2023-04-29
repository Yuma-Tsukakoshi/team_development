<?php 
require_once(dirname(__FILE__) . '/../dbconnect.php');
require_once(dirname(__FILE__) . '/user_agent_filter.php');

$pdo = Database::get();
$labels = $pdo->query("SELECT * FROM labels")->fetchAll(PDO::FETCH_ASSOC);
$agent_labels = $pdo->query("SELECT * FROM label_client_relation INNER JOIN labels ON label_client_relation.label_id = labels.label_id")->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../user/assets/styles/search.css">
  <script src="./assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="./assets/js/filter.js" defer></script>
  <title>エージェント検索一覧</title>
</head>

<body>
  <?php include(dirname(__FILE__) . '/../components/header.php'); ?>
  <section class="search">
    <div>
      <h1 class="search-title">SEARCH</h1>
      <span class="search-title-jpn">-エージェント検索-</span>
      <div class="search-title-border"></div>
    </div>
    <div>
      <img class="search-title-cart" src="../user/assets/img/728.png" alt="shopping_cart">
      <div class="search-title-cart-border"></div>
    </div>
  </section>

  <main class="grid grid-cols-2">
    <form method="post" action="" class="m-8">
      <div class="major">
        <h2 class="major-txt">専攻</h2>
        <img class="major-pencil-img" src="../user/assets/img/1263.png" alt="鉛筆の画像">
        <?php for($i=1;$i<=2;$i++){ ?>
        <input type="checkbox" id="major<?=$i?>" class="check-label" name="filter[]" value="<?=$labels
        [$i-1]["label_id"] ?>">
        <label for="major<?=$i?>" class="label-hover<?=$i?>"><?=$labels[$i-1]["label_name"] ?> </label>
        <?php }?>
        <div class="major-border"></div>
      </div>
      <div class="contact">
        <h2 class="contact-txt">面談方法</h2>
        <img class="contact-mail-img" src="../user/assets/img/550.png" alt="メールの画像">
        <div class="contact-checkbox">
          <?php for($i=3;$i<=5;$i++){ ?>
          <input type="checkbox" id="contact<?=$i?>"  class="check-label contact-checkbox" name="filter[]" value="<?=$labels[$i-1]["label_id"] ?>">
          <label for="contact<?=$i?>" class="label-hover"><?=   $labels[$i-1]["label_name"] ?> </label>
          <?php }?>
          <div class="contact-border"></div>
        </div>
      </div>
      <div class="area">
        <h2 class="area-txt"> エリア </h2>
        <img class="area-point-img" src="../user/assets/img/686.png" alt="ピンの写真">
        <?php for($i=6;$i<=9;$i++){ ?>
        <input type="checkbox" id="area<?=$i?>" class="check-label" name="filter[]" value="<?=$labels[$i-1]["label_id"] ?>">
        <label for="area<?=$i?>" class="label-hover"><?= $labels[$i-1]["label_name"] ?></label>
        <?php }?>
      </div>
      <button class="btn-big blue">検索</button>
    </form>
    <div >
      <div class="results">
          <img class="results-img" src="./assets/img/629.png" alt="虫眼鏡の画像">
          <span class="results-txt"><?=count($agents)?>件ヒット</span>
      </div>
      <div>
        <div class="my-16 ">
          <?php foreach ($agents as $key => $agent) { ?>
          <div class="top agent-list">
              <img class="agent-img" src="<?=$agent["logo_img"]?>" alt="エージェント画像">
            <div>
              <h2 class="top-title"><?=$agent["service_name"]?></h2>
              <div class="top-title-border"></div>
              <div class="top-description">
                <h3 class="top-description-title"><?=$agent["catchphrase"]?></h3>
                <p><?=$agent["recommend_point1"]?></p>
                <p><?=$agent["recommend_point2"]?></p>
                <p><?=$agent["recommend_point3"]?></p>
              </div>
              <div class="top-description-border"></div>
            </div>
          </div>
          <div class="bottom">
            <div class="labels">
              <?php foreach($agent_labels as $agent_label){ ?>
              <?php if($agent_label["client_id"]==$agent["client_id"]){?>
              <span class="label-major">
                <?=$agent_label["label_name"]?>
              </span>
              <?php }?>
              <?php }?>
            </div>
            <div class="block">
              <button class="btn-big cyan add-cart" id="cart<?=$key+1?>">カートに追加する</button>
              <button class="btn-big blue see-details" id="agent<?=$key+1?>">詳細を見る→</button>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
