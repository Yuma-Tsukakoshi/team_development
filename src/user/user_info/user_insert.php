<?php
require_once(dirname(__FILE__) . '/../../dbconnect.php');

session_start();
$pdo=Database::get();
$agent_id=$_SESSION['products']['agent'];
$agents=$pdo->query("SELECT * FROM clients where client_id = $agent_id")->fetchAll(PDO::FETCH_ASSOC);
//print_r($agents[0]);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申し込みフォーム</title>
  <!-- スタイルシート読み込み -->
  <!--<link rel="stylesheet" href="./user/assets/styles/common.css">-->
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--<script type="text/javascript" src="./../assets/js/jquery.zip2addr.js"></script>-->
</head>

<body>
  <header>

  </header>
  <main>
    <h1>申し込みフォーム</h1>
    <form method="post" action="http://localhost:8080/user/user_info/user_insert.check.php">
      <div class="form-controll">
        <label for="name" class="form-label">名前:</label>
        <input type="text" name="name" id="name" class="form-control" required/>
      </div>
      <div class="form-controll">
        <label for="hurigana" class="form-label">ふりがな:</label>
        <input type="text" name="hurigana" id="hurigana" class="form-control" required/>
      </div>
      <div class="form-controll">
        <label for="email" class="form-label">メールアドレス:</label>
        <input type="email" name="email" id="email" class="form-control"  pattern="^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$"  title="メールアドレスを正しく入力してください" required/>
      </div>
      <div class="form-controll">
        <label for="phone" class="form-label">電話番号:</label>
        <input type="tel" name="phone" id="phone" class="form-control" pattern="\d{1,5}-\d{1,4}-\d{4,5}" title="電話番号は、市外局番からハイフン（-）を入れて記入してください。" required/>
      </div>
      <div class="form-controll">
        <label for="sex" class="form-label">性別:</label>
        <input type="radio" name="sex" id="sex" value="女" class="form-control" required/>女性
        <input type="radio" name="sex" id="sex" value="男" class="form-control" required/>男性
        <input type="radio" name="sex" id="sex" value="その他" class="form-control" required/>その他
      </div>
      <div class="form-controll">
        <label for="birthday" class="form-label">生年月日:</label>
        <input type="date" name="birthday" id="birthday" class="form-control" required/>
      </div>
      <div class="form-controll">
        <!--都道府県に変更
        <label for="address" class="form-label">郵便番号:</label>
        <input type="text" id="address" class='form-control'name="address" onKeyUp="$('#address').zip2addr('#address_detail');"  required><br/>
        <label for="address_detail" class="form-label" required>住所:</label>
        <input type="text"class='form-control'name="address_detail" id="address_detail" >-->
        <label for="prefecture" class="form-label">住まいの都道府県:</label>
        <input type="text" name="prefecture" id="prefecture" class="form-control" required/>
      </div>
      <div class="form-controll">
        <label for="college" class="form-label">大学名:</label>
        <input type="text" name="college" id="college" class="form-control" required/>
      </div>
      <div class="form-controll">
        <label for="faculty" class="form-label">学部:</label>
        <input type="text" name="faculty" id="faculty" class="form-control" required/>
        <label for="department" class="form-label">学科:</label>
        <input type="text" name="department" id="department" class="form-control" required/>
        <label for="division" class="form-label">文理:</label>
        <input type="radio" value="文系" name="division" id="division" class="form-control" required/>文系
        <input type="radio" value="理系" name="division" id="division" class="form-control" required/>理系

        <label for="grad_year" class="form-label">卒業年度:</label>
        <input type="text" name="grad_year" id="grad_year" class="form-control" required/>
      
      </div>
      <div class="form-control">
        <h2>申し込み企業一覧</h2>
        <?php foreach($agents as $agent){ ?>
        <input type="text" name="company" id="company" class="form-control"  value="<?=$agent["agent_name"]?>" >
        <?php }?>
      </div>
      <input type="submit" id="submit-button"value="送信" >
    
    </form>
    
      
  </main>
  <!-- <script>
  $count=0;
   /*$(function(){
      $('.edit-button').click(function(){
      $number=$(this).data('value')
      $('.form-control').eq($number-1).prop('disabled',false)
      $('.form-control').eq($number-1).val('')
      $count++;
   
    })
   })*/
  $(function(){
    //全て入力されたら送信ボタンを押せる これだどinput内容の判定してない
    /*$('#grad_year').on('keyup',function(event){
      if($('#name').val()==null || $('#hurigana').val()==null || $('#email').val()==null || $('#phone').val()==null || $('input[name="sex"]:checked').val()==null || $('#birthday').val()==null || $('#college').val()==null || $('#faculty').val()==null|| $('#department').val()==null || $('input[name="division"]:checked').val()==null || $('#grad_year').val()==null || $('#prefecture').val()==null){
        $('#submit-button').prop('disabled',true)
                    
      }
      else{
        $('#submit-button').prop('disabled',false)
      }

    })*/
   
    $("#submit-button").on('click', function(event){
                //event.preventDefault();
                var btn  = $(this);
                var form = $(this).closest('form');
            
                //required対策
                if($(form).find(':invalid').length === 0)
                {
                    $(btn).prop('disabled', true);
            
                    
                  $.ajax({
                    type: "POST",
                    url: "./user_insert.done.php",
                    data: {
                      name:$('#name').val(),
                      hurigana: $('#hurigana').val(),
                      email:$('#email').val(),
                      phone:$('#phone').val(),
                      sex:$('input[name="sex"]').val(),
                      birthday:$('#birthday').val(),
                      college:$('#college').val(),
                      faculty:$('#faculty').val(),
                      department:$('#department').val(),
                      division:$('input[name="division"]').val(),
                      grad_year:$('#grad_year').val(),
                      prefecture:$('#prefecture').val(),
                      
                    },
                    dataType : "json",
                    scriptCharset: 'utf-8'
                  }).done(function(data){
                    //console.log(data);
                  
                    window.location.href='./user_thanks.php'
                    
                  }).fail(function(XMLHttpRequest, textStatus, errorThrown){
                      console.log(errorThrown);
                  });
                }
                else
                {
                    //ツールチップを表示
                    $(form).find(':invalid').show();
                }
               
                  
               
            });

  })


  </script> -->
</body>
</html>
