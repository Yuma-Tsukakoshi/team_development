function countVisibleElements() {
  // 表示されている要素を取得
  var visibleElements = $('.agent-item').filter(function() {
    return $(this).css('display') !== 'none';
  });
  console.log(visibleElements);
  // 表示されている要素の数を取得
  var count = visibleElements.length;
  // カウントを表示する
//   console.log(count);
  $('.results-number').text(count);
}


$('input[type="checkbox"]').change(function(){
    var filters = [];
    $('input[type="checkbox"]:checked').each(function(){
        filters.push($(this).val());
    });

    if (filters.length > 0) {
        $('.agent-item').fadeOut(100);
        $('.agent-item').each(function(){
            var options = $(this).data('options').split(' ');
            var match = true; // AND条件のために変更
            for (var i = 0; i < filters.length; i++) { // 絞り込み条件のループを変更
                if ($.inArray(filters[i], options) === -1) {
                    match = false; // AND条件のために変更
                    break; // 絞り込み条件に該当しない場合は、ループを終了する
                }
            }
            if (match) {
                $(this).fadeIn(300);
            }
        });
    } else {
        $('.agent-item').fadeIn(300);
    }
    countVisibleElements();
});

