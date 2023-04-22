<?php 
require_once(dirname(__FILE__) . '/../dbconnect.php');

$pdo = Database::get();
$labels = $pdo->query("SELECT * FROM labels")->fetchAll(PDO::FETCH_ASSOC);
$agent = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);

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
      <h3><span>1</span>件ヒット</h3>
      <div class="agent-list">
        <!-- ダミーとしてマイナビ新卒紹介 -->
        <div>
          <div class="top">
            <img src="" alt="エージェント画像">
            <div>
              <h2>マイナビ新卒紹介</h2>
              <div>
                <h3>業界最高峰の求人数</h3>
                <p>様々な分野に挑戦してみたい、選考対策まで行って欲しい人におすすめです</p>
              </div>
            </div>
          </div>
          <div class="buttom">
            <div class="labels">
              <!-- TODO labelとエージェントテーブル繋げるphpファイル読み込んで反映させる -->
              <span>文系</span>
              <span>オンライン</span>
              <span>東京</span>
            </div>
            <div class="block">
              <button class="btn-big blue">カートに追加する</button>
              <button class="btn-big blue">詳細を見る→</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
