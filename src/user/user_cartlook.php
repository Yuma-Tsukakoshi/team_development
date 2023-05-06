<?php
 require_once(dirname(__FILE__) . './../dbconnect.php');

session_start();
$pdo=Database::get();
$clients=array();

if(isset($_SESSION['clients'])){
  $agents=$_SESSION['clients'];
  foreach($agents as $agent){
    $client=$agent['agent'];
    $client_name= $pdo->query("SELECT client_id,agent_name FROM clients where client_id = $client")->fetchAll(PDO::FETCH_ASSOC);
    array_push($clients,$client_name[0]);
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../user/assets/styles/search.css">
  <link rel="stylesheet" href="../user/assets/styles/header.css">
  
  <script src="./assets/js/jquery-3.6.1.min.js" defer></script>
  <script src="./assets/js/filter.js" defer></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <title>エージェント検索一覧</title>
</head>

<body>
  <?php include(dirname(__FILE__) . '/../components/header.php'); ?>
  <section>
      <h1>カート</h1>
  </section>
  <main>
    <div class="cart-content">
      <ul>
        <?php 
        if($clients != null){
        for($i=0; $i<count($clients); $i++){?>
        
        <li class="flex justify-between my-5">
          <?=$clients[$i]['agent_name']?>
          
          <button class="btn-big blue delete-btn" type="button" value="<?= $clients[$i]['client_id']?>" >削除</button>
        </li>
        <?php }}?>
      </ul>
      <div >
        <a class="contact-link" href="./user_info/user_insert.php">お申し込み確認フォーム</a>
      </div>
    </div>
    
  </main>
  <script>
    $(function(){
            $('.btn-big').on('click', function(event){
              $index=this.value
              //$(this).parent('li').remove()
              var el=$(this);
              //alert($('.client_id').eq($index).val());
                $.ajax({
                    type: "POST",
                    url: "./user_cartdelete.php",
                    data: {
                      id: $index,
                      //client_id:$('.client_id').eq($index).val(),
                      
                    },
                    dataType : "json",
                    scriptCharset: 'utf-8'
                }).done(function(data){
                  console.log(data);
                  el.parent('li').remove()

                
                }).fail(function(XMLHttpRequest, textStatus, errorThrown){
                    alert(errorThrown);
                });
            })
          })
    
  </script>
</body>

</html>