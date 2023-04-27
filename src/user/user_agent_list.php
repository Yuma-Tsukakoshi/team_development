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
  <script src="./assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="./assets/js/filter.js" defer></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
      <img src="" alt=" shopping_cart">
    </div>
  </section>

  <main class="grid grid-cols-2">
    <form method="post" action="">
      <div class="major">
        <h2> 専攻 </h2>
        <?php for($i=1;$i<=2;$i++){ ?>
        <input type="checkbox" id="major<?=$i?>" class="check-label" name="filter[]" value="<?=$labels
        [$i-1]["label_id"] ?>">
        <label for="major<?=$i?>" class="label-hover"><?=$labels[$i-1]["label_name"] ?> </label>
        <?php }?>
      </div>
      <div class=" contact">
        <h2> 面談方法 </h2>
        <?php for($i=3;$i<=5;$i++){ ?>
        <input type="checkbox" id="contact<?=$i?>" class="check-label" name="filter[]" value="<?=$labels[$i-1]["label_id"] ?>">
        <label for="contact<?=$i?>" class="label-hover"><?= $labels[$i-1]["label_name"] ?> </label>
        <?php }?>
      </div>
      <div class="area">
        <h2> エリア </h2>
        <?php for($i=6;$i<=9;$i++){ ?>
        <input type="checkbox" id="area<?=$i?>" class="check-label" name="filter[]" value="<?=$labels[$i-1]["label_id"] ?>">
        <label for="area<?=$i?>" class="label-hover"><?= $labels[$i-1]["label_name"] ?></label>
        <?php }?>
      </div>
      <button class="btn-big blue">検索</button>
    </form>
    <div>
      <!-- fileterｓのカウントを入れる -->
      <!-- <h3><span><?=$filters?></span>件ヒット</h3> -->
      <div class="agent-list">
        <div>
          <?php foreach ($agents as $key => $agent) { ?>
          <input type="hidden" value="<?=$agent['client_id']?> " class="client_id">
          <div class="top">
            <img src="<?=$agent["logo_img"]?>" alt="エージェント画像">
            <div>
              <h2><?=$agent["service_name"]?></h2>
              <div>
                <h3><?=$agent["catchphrase"]?></h3>
                <p><?=$agent["recommend_point1"]?></p>
                <p><?=$agent["recommend_point2"]?></p>
                <p><?=$agent["recommend_point3"]?></p>
              </div>
            </div>
          </div>
          <div class="bottom">
            <div class="labels">
              <?php foreach($agent_labels as $agent_label){ ?>
              <?php if($agent_label["client_id"]==$agent["client_id"]){?>
              <span>
                <?=$agent_label["label_name"]?>
              </span>
              <?php }?>
              <?php }?>
            </div>
            <div class="block">
              <button class="btn-big blue"  value="<?=$key?>" id="cart<?=$key+1?>">カートに追加する</button>
              <button class="btn-big blue" id="agent<?=$key+1?>">詳細を見る→</button>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
  </main>
  <script>
  $(function(){
            $('.btn-big').on('click', function(event){
              $index=this.value
              alert($('.client_id').eq($index).val());
                $.ajax({
                    type: "POST",
                    url: "./user_cartlook.php",
                    data: {
                      client_id:$('.client_id').eq($index).val(),
                      
                    },
                    dataType : "json",
                    scriptCharset: 'utf-8'
                }).done(function(data){
                  alert(data);
                
                }).fail(function(XMLHttpRequest, textStatus, errorThrown){
                    alert(errorThrown);
                });
            })
          })
  </script>
</body>

</html>
