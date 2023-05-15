$(document).ready(function() {
    ///スライド
$('.slider').slick({
    autoplay: true, // 自動的に動き出すか。初期値はfalse。
    infinite: true, // スライドをループさせるかどうか。初期値はtrue。
    speed: 10000, // スライドのスピード。初期値は300。
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
  
  // $(function(){
  //   $(window).scroll(function (){
  //       $('.star-fadein').each(function(){
  //           var position = $(this).offset().top;
  //           var scroll = $(window).scrollTop();
  //           var windowHeight = $(window).height();
  //           if (scroll > position - windowHeight + 200){
  //             $(this).addClass('active');
  //           }
  //       });
  //   });
  // });