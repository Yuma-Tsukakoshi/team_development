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
});
