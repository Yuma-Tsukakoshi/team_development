"use strict"

//可視範囲にきたら星流れる
$(window).scroll(function() {
  var scrollPosition = $(window).scrollTop();
  var windowHeight = $(window).height();

  $('.star-box4').each(function() {
    var offsetTop = $(this).offset().top;

    if (scrollPosition > offsetTop - windowHeight + 200) {
      $(this).addClass('appear');
    }
  });
});

// ↓これできてる！タイトルがふわっと出てくるやつ
// 動きのきっかけとなるアニメーションの名前を定義
function fadeAnime(){

  // ふわっ
  $('.howto-title,.handling-title,.handling-jpn,.voices-title,.voices-title-jpn,.creator-title,.creator-title-jpn,.about-title,.about-title-jpn').each(function(){ //fadeUpTriggerというクラス名が
    var elemPos = $(this).offset().top-50;//要素より、50px上の
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= elemPos - windowHeight){
    $(this).addClass('fadeUp');// 画面内に入ったらfadeUpというクラス名を追記
    }else{
    $(this).removeClass('fadeUp');// 画面外に出たらfadeUpというクラス名を外す
    }
    });
}
// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function (){
  fadeAnime();/* アニメーション用の関数を呼ぶ*/
});// ここまで画面をスクロールをしたら動かしたい場合の記述


// ハンバーガーメニュー
$(function() {
  $('.menu-btn').click(function() {
      $(this).toggleClass('active');

      if ($(this).hasClass('active')) {
          $('.gnavi__sp-style').addClass('active');
          // $('.sp-header-li').addClass('active');
      } else {
          $('.gnavi__sp-style').removeClass('active');
          // $('.sp-header-li').removeClass('active');
      } 
  });
});

// ハンバーガーメニューのリンクのジャンプ
$(document).ready(function() {
  $('.gnavi__sp-style a').click(function(e) {
    e.preventDefault(); // リンクのデフォルトのクリック動作を無効化

    var target = $(this).data('target'); // data-target属性の値を取得
    $('.modal').hide(); // モーダルを非表示にする

    // 対象のセクションにスクロールしてジャンプする
    $('html, body').animate({
      scrollTop: $(target).offset().top
    }, 500);
  });
});




