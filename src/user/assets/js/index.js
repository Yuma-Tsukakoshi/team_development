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

