"use strict"
//その場所に来たら、流れ星が流れて欲しい。
// window.addEventListener("scroll", function () {
//     const star2 = document.querySelector(".star-box2");
//     const scroll = window.pageYOffset;
//     if (scroll > 300) {
//     star2.style.opacity = "1";
//       // console.log(scroll);
//     } else {
//     star2.style.opacity = "0";
//       // console.log(scroll);
//     }
// });

$(function(){
  $(window).scroll(function (){
      $('.title').each(function(){
          var position = $(this).offset().top;
          var scroll = $(window).scrollTop();
          var windowHeight = $(window).height();
          if (scroll > position - windowHeight + 200){
            $(this).addClass('active');
          }
      });
  });
});

// タイトルもフェードで入れようとしたら消えちゃった、、、！

$(function() {
  // スクロールイベント
    $(window).scroll(function() {
      // フェードアニメーションを呼び出す
      fadeAnime();
    });
    
    // フェードアニメーションの設定
    function fadeAnime() {
      // .fadeUpTriggerが付いた要素に対して
      $('.star').each(function() {
        // 縦位置を取得し-50pxして、変数targetに代入する
        let target = $(this).offset().top -= 50;
        // スクロール量を取得し、変数scrollに代入する
        let scroll = $(window).scrollTop();
        // 表示画面の高さを取得し、変数windowHeightに代入する
        let windowHeight = $(window).height();
        // 要素の縦位置から表示画面の高さを引いて200pxを足した数字よりscrollのほうが大きい場合
        if(scroll > target - windowHeight ) {
          // .fadeUpを追加する
          $(this).addClass('move');
        } else {
          // そうでない場合は.fadeUpを削除する
          $(this).removeClass('move');
        }
      });
    };    
  });
  
  
  

