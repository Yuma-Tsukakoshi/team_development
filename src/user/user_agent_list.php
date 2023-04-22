<?php 
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$labels = $pdo->query("SELECT * FROM labels")->fetchAll(PDO::FETCH_ASSOC);
$agents = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);
$agents_label = $pdo->query("SELECT * FROM label_client_relation INNER JOIN labels ON  label_client_relation.label_id = labels.label_id")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.css">
  <title>エージェント検索一覧</title>
</head>

<body>
  <?php include(dirname(__FILE__) . '/../components/header.php'); ?>
  <section class="">
    <div>
      <h1>SEARCH</h1>
      <span>-エージェント検索-</span>
    </div>
    <div>
      <img src="" alt="shopping_cart">
    </div>
  </section>

  <main class="grid grid-cols-2">
    <div class="m-8">
      <div class="major">
        <!-- font-awsomeで入れてく--->
        <h2>専攻</h2>
        <?php for($i=1;$i<=2;$i++){ ?>
        <input type="checkbox" id="major<?=$i?>" class="check-label" value="<?=$labels
        [$i-1]["label_name"] ?>"><label for="major<?=$i?>"
          class="label-hover"><?=$labels[$i-1]["label_name"] ?></label>
        <?php }?>
      </div>
      <div class=" contact">
        <h2>面談方法</h2>
        <?php for($i=3;$i<=5;$i++){ ?>
        <input type="checkbox" id="contact<?=$i?>" class="check-label" value="<?=$labels[$i-1]["label_name"] ?>"><label
          for="contact<?=$i?>" class="label-hover"><?= $labels[$i-1]["label_name"] ?></label>
        <?php }?>
      </div>
      <div class="area">
        <h2>エリア</h2>
        <?php for($i=6;$i<=9;$i++){ ?>
        <input type="checkbox" id="area<?=$i?>" class="check-label" value="<?=$labels[$i-1]["label_name"] ?>"><label
          for="area<?=$i?>" class="label-hover"><?= $labels[$i-1]["label_name"] ?></label>
        <?php }?>
      </div>
      <button class="btn-big blue">検索</button>
    </div>
    <div>
      <h3><span>6</span>件ヒット</h3>
      <div class="agent-list">
        <div>
          <?php foreach ($agents as $key => $agent) { ?>
          <div class="top">
            <img src="<?=$agent["logo_img"]?>" alt="エージェント画像">
            <div>
              <h2><?=$agent["agent_name"]?></h2>
              <div>
                <h3><?=$agent["service_name"]?></h3>
                <p><?=$agent["recommend_point1"]?></p>
                <p><?=$agent["recommend_point2"]?></p>
                <p><?=$agent["recommend_point3"]?></p>
              </div>
            </div>
          </div>
          <div class="bottom">
            <div class="labels">
              <!-- TODO labelとエージェントテーブル繋げるphpファイル読み込んで反映させる -->
              <!-- まだ紐付けてないから一旦全部ダミーで -->
              <?php while($agents_label["client_id"]==$key+1){ ?>
              <span></span>
              <?php }?>
            </div>
            <div class="block">
              <button class="btn-big blue" id="cart<?=$key+1?>">カートに追加する</button>
              <button class="btn-big blue" id="agent<?=$key+1?>">詳細を見る→</button>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
