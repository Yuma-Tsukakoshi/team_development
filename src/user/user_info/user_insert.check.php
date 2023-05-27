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
  <link rel="stylesheet" href="./../../vendor/tailwind/tailwind.css">
  <link rel="stylesheet" href="../assets/styles/header.css">
  <link rel="stylesheet" href="../assets/styles/form.css">
  <link rel="stylesheet" href="../assets/styles/cart.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
  <?php include(dirname(__FILE__) . './../../components/header.php'); ?>
  <main>
    <div class="phase-image">
      <div class="first-box">カート一覧</div>
      <div class="border-line"></div>
      <div class="second-box">申し込み<span>フォーム</span></div>
      <div class="border-line"></div>
      <div class="third-box">申し込み<span>確認</span></div>
      <div class="border-line"></div>
      <div class="fourth-box">完了</div>

    </div>
    <div class="check-form" >
      <div class="text-2xl text-gray-800 font-bold mb-6">申し込み確認フォーム</div>
      <div class="mb-4 ">
        <label class="block text-gray-700 font-bold mb-2" for="name">名前</label>
        <div class="flex">
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="name"id="name" type="text" value="<?=$_POST['name']?>" disabled>
          <button class="edit-button" data-value="1">編集</button>
        </div>
      </div>
      <div class="mb-4 ">
        <label class="block text-gray-700 font-bold mb-2" for="hurigana">ふりがな</label>
        <div class="flex">
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="hurigana"id="hurigana" type="text" value="<?=$_POST['hurigana']?>" disabled>
          <button class="edit-button" data-value="2">編集</button>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="email">メールアドレス</label>
        <div class="flex">
            <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="email" id="email" type="text" value="<?=$_POST['email']?>" pattern="^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$" title="メールアドレスを正しく入力してください" disabled>
            <button class="edit-button" data-value="3">編集</button>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="phone">電話番号(ハイフンあり)</label>
        <div class="flex">
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="phone"id="phone" type="tel" value="<?=$_POST['phone']?>"pattern="\d{1,5}-\d{1,4}-\d{4,5}" title="電話番号は、市外局番からハイフン（-）を入れて記入してください。" disabled>
          <button class="edit-button" data-value="4">編集</button>
        </div>
      </div>
      <div class="mb-4">
        <div>
          <label class="block text-gray-700 font-bold mb-2" for="sex">性別</label>
          <div class="flex radio-field">
            <div class="radio-input">
              <input type="radio" name="sex" id="sex" value="女"  <?php if( $_POST['sex'] == '女'){?>checked<?php }?> class="radio-button" disabled/>女性
            </div>
            <div class="radio-input">
              <input type="radio" name="sex" id="sex" value="男" <?php if( $_POST['sex'] == '男'){?>checked<?php }?> class="radio-button"disabled/>男性
            </div>
            <div class="radio-input">
              <input type="radio" name="sex" id="sex" value="その他" <?php if( $_POST['sex'] == 'その他'){?>checked<?php }?> class="radio-button"disabled/>その他
            </div>
            <button class="edit-button"  type="button" data-name="sex" data-type="radio" >編集</button>
          </div>
        </div>    
      </div>
      <div class="mb-4 ">
        <label class="block text-gray-700 font-bold mb-2" for="birthday">生年月日</label>
        <div class="flex">
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="birthday"id="birthday" type="date" value="<?=$_POST['birthday']?>" disabled>
          <button class="edit-button" data-value="5">編集</button>
        </div>
      </div>
      <div class="mb-4 ">
        <label class="block text-gray-700 font-bold mb-2" for="prefecture">住まいの都道府県</label>
        <div class="flex">
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="prefecture"id="prefecture" type="text" value="<?=$_POST['prefecture']?>" disabled>
          <button class="edit-button" data-value="6">編集</button>
        </div>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="college">大学名</label>
        <div class="flex">
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" name="college"id="college" type="text" value="<?=$_POST['college']?>" disabled>
          <button class="edit-button" data-value="7">編集</button>
        </div>
      </div>
      <div class="mb-4">
        <div class="form-control flex">
        <div class="double-input">
          <label class="block text-gray-700 font-bold mb-2 " for="faculty">学部</label>
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline " name="faculty"id="faculty" type="text" value="<?=$_POST['faculty']?>" disabled >
        </div>
        <div class="double-input">
          <label class="block text-gray-700 font-bold mb-2" for="department">学科</label>
          <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="department"id="department" type="text" disabled value="<?=$_POST['department']?>" >
        </div>
        <button class="edit-button button-mg" type="button"  data-type="double">編集</button>
        </div>
  
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2 " for="faculty">文理</label>
        <div class="flex radio-field">
          <div class="radio-input">
            <input type="radio" name="division" id="division"  value="文系" <?php if( $_POST['division'] == '文系'){?>checked<?php }?> class="radio-button" disabled />文系
          </div>
          <div class="radio-input">
            <input type="radio" name="division" id="division"
            value="理系" <?php if( $_POST['division'] == '理系'){?>checked<?php }?> class="radio-button" disabled />理系
          </div>
          <button class="edit-button"  type="button" data-name="division" data-type="radio" >編集</button>
        </div>
      </div>  
       
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="grad_year">卒業年度</label>
        <input class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control " name="grad_year"id="grad_year" type="text" value="<?=$_POST['grad_year']?>" disabled >
        <button class="edit-button" data-value="9">編集</button> 
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="company">申し込み企業一覧</label>
        <?php foreach($_POST['company'] as $agent){?>
        <input  name="company[]" class="appearance-none border rounded py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control " value="<?=$agent?>" disabled >
        <!-- <?php var_dump($agent); ?> -->
        <?php }?>
      </div>
      <div class="flex items-center justify-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline" id="submit-button"type="submit">
            送信する
        </button>
      </div>

    </div>
    
  </main>
  <script>
    $(function(){
      $('.first-box').css('background-color','#dcdcdc')
      $('.third-box').css('background-color','#ffff66')
    
    })
   $(function(){
      $('.edit-button').click(function(){
      $number=$(this).data('value')
      $type=$(this).data('type')
      $name=$(this).data('name')
      console.log($type)
      if($type=='radio'){
        var f=document.getElementsByName($name);
        for(var i=0;i<f.length;i++){
              f[i].disabled=false;
              f[i].required=true;
          }
      }
      else if($type=='double'){
        var f=document.getElementsByClassName('double-content');
        for(var i=0;i<f.length;i++){
              f[i].disabled=false;
              f[i].required=true;
              f[i].style.border = "1px solid #0071bc";
              f[i].value='';
          }
      }
      else{
        $('.form-control').eq($number-1).css('border','1px solid #0071bc')
        $('.form-control').eq($number-1).prop('disabled',false)
        $('.form-control').eq($number-1).prop('required',true)
        $('.form-control').eq($number-1).val('')
      }
    })
   })
  $(function(){
    const $company=[]
    const inputs = $('input[name="company[]"]').each(function(index, element){
        $company.push(element.value)
        })
    
    $("#submit-button").on('click', function(event){
                //event.preventDefault();
                console.log($('input[name="sex"]:checked').val());

                $.ajax({
                    type: "POST",
                    url: "./user_insert.done.php",
                    data: {
                      name:$('#name').val(),
                      hurigana: $('#hurigana').val(),
                      email:$('#email').val(),
                      phone:$('#phone').val(),
                      sex:$('input[name="sex"]:checked').val(),
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
