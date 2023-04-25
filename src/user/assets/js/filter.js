$('input[name="filter[]"]').change(function() {
    // 選択されているチェックボックスの値を取得
    var filters = $('input[name="filter[]"]:checked').map(function() {
        return $(this).val();
    }).get();

    console.log(filters);

    // AJAXを使用してPHPスクリプトに送信する
    $.ajax({
        url: 'http://localhost:8080/user/user_agent_filter.php',
        type: 'post',
        data: {filter: filters},
        success: function(response) {
            // 成功したら以下の文が送られる
            console.log("OK");
        }
    });
});
