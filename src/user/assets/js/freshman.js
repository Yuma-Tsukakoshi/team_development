$(document).ready(function() {
    ///スライド
$('.slider').slick({
    autoplay: true, // 自動的に動き出すか。初期値はfalse。
    infinite: true, // スライドをループさせるかどうか。初期値はtrue。
    speed: 300, // スライドのスピード。初期値は300。
    slidesToShow: 3, // スライドを画面に3枚見せる
    slidesToScroll: 1, // 1回のスクロールで1枚の写真を移動して見せる
    prevArrow: '<div class="slick-prev"></div>', // 矢印部分PrevのHTMLを変更
    nextArrow: '<div class="slick-next"></div>', // 矢印部分NextのHTMLを変更
    centerMode: true, // 要素を中央ぞろえにする
    variableWidth: true, // 幅の違う画像の高さを揃えて表示
    dots: true, // 下部ドットナビゲーションの表示
});
});

$(document).ready(function() {
    $('.header-button').click(function() {
      var target = $(this).data('target');
      $('html, body').animate({
        scrollTop: $(target).offset().top
      }, 500);
    });
  });
  
  $(function(){
    $(window).scroll(function (){
        $('.star3, .star4').each(function(){
            var position = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll > position - windowHeight + 200){
                $(this).addClass('active');  // activeクラスを追加
            }
        });
    });
});
  $(function(){
    $(window).scroll(function (){
        $(' .star5,.star6').each(function(){
            var position = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll > position - windowHeight + 1000){
                $(this).addClass('active');  // activeクラスを追加
            }
        });
    });
});

  $(function(){
    var star1 = $('.star1');
    var star2 = $('.star2');
    star1.on('animationend', function() {
        star2.css({
            'display': 'block',
            'animation': 'shooting2 3.0s linear'
        });
    });
});
$(function() {
  var star7 = $('.star7');
  var star8 = $('.star8');
  var star9 = $('.star9');
  var star10 = $('.star10');
  var star11 = $('.star11');

  star7.on('animationend', function() {
      star8.show().css('animation', 'shooting4 0.5s linear forwards');
  });

  star8.on('animationend', function() {
      star9.show().css('animation', 'shooting5 0.6s linear forwards');
  });

  star9.on('animationend', function() {
      star10.show().css('animation', 'shooting6 0.8s linear forwards');
  });

  star10.on('animationend', function() {
      star11.show().css('animation', 'shooting7 0.5s linear forwards');
  });
});





