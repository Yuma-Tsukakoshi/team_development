<?php
  //session_start();
  
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
  <script type="text/javascript" src="./../assets/js/jquery.zip2addr.js"></script>
</head>

<body>
  <header>

  </header>
  <main>
    <h1>お申し込み確認フォーム</h1>
    <!--<form action="./user_insert.done.php" method="post">-->
  
      <div class="form-controll" >
        <label for="name" class="form-label">名前:</label>
        <input type="text" name="name" id="name" class="form-control" value="<?=$_POST['name']?>" disabled/>
        <button class="edit-button" data-value="1">編集</button>
      </div>
      <div class="form-controll">
        <label for="hurigana" class="form-label">ふりがな:</label>
        <input type="text" name="hurigana" id="hurigana" class="form-control" value="<?=$_POST['hurigana']?>" disabled/>
        <button class="edit-button" data-value="2">編集</button>
      </div>
      <div class="form-controll">
        <label for="email" class="form-label">メールアドレス:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?=$_POST['email']?>" disabled/>
        <button class="edit-button" data-value="3">編集</button>
      </div>
      <div class="form-controll">
        <label for="phone" class="form-label">電話番号:</label>
        <input type="tel" name="phone" id="phone" class="form-control" pattern="\d{1,5}-\d{1,4}-\d{4,5}" title="電話番号は、市外局番からハイフン（-）を入れて記入してください。" value="<?=$_POST['phone']?>" disabled/>
        <button class="edit-button" data-value="4">編集</button>
      </div>
      <div class="form-controll">
        <fieldset class="form-control" disabled>
        <label for="sex" class="form-label">性別:</label>
        <input type="radio" name="sex" id="sex" value="女"  <?php if( $_POST['sex'] == '女'){?>checked<?php }?>/>女性
        <input type="radio" name="sex" id="sex" value="男" <?php if( $_POST['sex'] == '男'){?>checked<?php }?> />男性
        <input type="radio" name="sex" id="sex" value="その他" <?php if( $_POST['sex'] == 'その他'){?>checked<?php }?>/>その他
        </fieldset>
        <button class="edit-button" data-value="5">編集</button>

      </div>
      <div class="form-controll">
        <label for="birthday" class="form-label">生年月日:</label>
        <input type="date" name="birthday" id="birthday" class="form-control" value="<?=$_POST['birthday']?>" disabled/>
        <button class="edit-button" data-value="6">編集</button>
      </div>
      <div class="form-controll">
        <!--自動入力-->
        <fieldset class="form-control" disabled>
          <!-- <label for="address" class="form-label">郵便番号:</label>
          <input type="text" id="address" name="address" onKeyUp="$('#address').zip2addr('#address_detail');" value="<?=$_POST['address']?>" ><br/>
          <label for="address_detail" class="form-label">住所:</label>
          <input type="text" name="address_detail" id="address_detail" value="<?=$_POST['address_detail']?>" > -->
          <label for="prefecture" class="form-label">住まいの都道府県:</label>
          <input type="text" name="prefecture" id="prefecture" value="<?=$_POST['prefecture']?>">
        </fieldset>
        <button class="edit-button" data-value="7">編集</button>
      </div>
      <div class="form-controll">
        <label for="college" class="form-label">大学名:</label>
        <input type="text" name="college" id="college" class="form-control" value="<?=$_POST['college']?>" disabled/>
        <button class="edit-button" data-value="8">編集</button>
      </div>
      <div class="form-controll">
        <fieldset class="form-control" disabled>
        <label for="faculty" class="form-label">学部:</label>
        <input type="text" name="faculty" id="faculty"  value="<?=$_POST['faculty']?>" />
        <label for="department" class="form-label">学科:</label>
        <input type="text" name="department" id="department"  value="<?=$_POST['department']?>" />

        </fieldset>
        <button class="edit-button" data-value="9">編集</button>
      </div>
      <div class="form-controll">
        <fieldset class="form-control" disabled>
          <label for="division" class="form-label">文理:</label>
          <input type="radio" name="division" id="division"  value="理系" <?php if( $_POST['division'] == '文系'){?>checked<?php }?> />文系
          <input type="radio" name="division" id="division"
          value="理系" <?php if( $_POST['division'] == '理系'){?>checked<?php }?> />理系
        </fieldset>
        <button class="edit-button" data-value="10">編集</button>
      </div>
      <div class="form-controll">
        <label for="grad_year" class="form-label">卒業年度:</label>
        <input type="text" name="grad_year" id="grad_year" class="form-control" value="<?=$_POST['grad_year']?>" disabled/>
        <button class="edit-button" data-value="11">編集</button>

      </div>
      
      <div class="form-control">
        <h2>申し込み企業一覧</h2>
        <?php foreach($_POST['company'] as $agent){?>
        <input type="text" name="company[]"  class="form-control" value="<?=$agent?>" disabled>
        <?php }?>
      </div>


      <input type="submit" id="submit-button" value="送信">
  </main>
  <script>
  $count=0;
   $(function(){
      $('.edit-button').click(function(){
      $number=$(this).data('value')
      $('.form-control').eq($number-1).prop('disabled',false)
      $('.form-control').eq($number-1).val('')
      $count++;
   
    })
   })
  $(function(){
    const $company=[]
    const inputs = $('input[name="company[]"]').each(function(index, element){
        $company.push(element.value)
        })
    console.log($company)
    $("#submit-button").on('click', function(event){
                //event.preventDefault();

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
                      company:$company
                    },
                    dataType : "json",
                    scriptCharset: 'utf-8'
                }).done(function(data){
                  console.log(data);
                
                  window.location.href='./user_thanks.php'
                  
                }).fail(function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                });
            });

  })


  </script>
</body>
</html>