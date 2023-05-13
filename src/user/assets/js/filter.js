// $('input[name="filter[]"]').change(function() {
//     // 選択されているチェックボックスの値を取得
//     var filters = $('input[name="filter[]"]:checked').map(function() {
//         return $(this).val();
//     }).get();

//     console.log(filters);

//     // AJAXを使用してPHPスクリプトに送信する
//     $.ajax({
//         url: 'http://localhost:8080/user/user_agent_filter.php',
//         type: 'post',
//         data: {filter: filters},
//         success: function(response) {
//             // 成功したら以下の文が送られる
//             console.log("OK");
//         }
//     });
// });

$('input[type="checkbox"]').change(function(){
    var filters = [];
    $('input[type="checkbox"]:checked').each(function(){
    filters.push($(this).val());
});

if (filters.length > 0) {
    $('ul li').hide();
    // slideinで中に入れる
    $('ul li').each(function(){
    var options = $(this).data('options').split(' ');
    var match = false;
    for (var i = 0; i < options.length; i++) {
        if ($.inArray(options[i], filters) !== -1) {
            match = true;
        }
    }
    if (match) {
        $(this).show();
    }
    });
} else {
    $('ul li').show();
    // slidein down とかで出し入れするといいかも
}
});

