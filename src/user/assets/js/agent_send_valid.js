$(document).ready(function() {
  $('#valid_btn').click(function() {
    var inputVal = $(this).attr('data'); // input要valueを取
    console.log(inputVal);
    $.ajax({
      url: 'http://localhost:8080/user/user_info/boozer_update_invalid.php', // 送信先のPHPファイルのパス
      type: 'POST',
      data: {
        input: inputVal
      }, // 送信するデータ。キーは'inputVal'、値はinputVの値
      success: function(data) {
        // 送信が成功した場合の処理
        console.log(data); // レスポンスデータをコンソに表示
      },
      error: function(xhr, status, error) {
        // 送信が失敗した場合の処理
        console.error(xhr); // エラー内容をコンソールに表示
      }
    });
    location.reload();
  });
});
