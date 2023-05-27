// 申請拒否
$(document).ready(function() {
  $('#invalid_btn').click(function() {
    var data = this.getAttribute('data'); 
    var clientId = this.getAttribute('client'); 
    $.ajax({
      url: 'http://localhost:8080/user/user_info/boozer_update_invalid.php', // 送信先のPHPファイルのパス
      type: 'POST',
      data: {
        data: data,
        clientId: clientId,
      }, 
      contentType: "application/x-www-form-urlencoded",
      processData: true,
      // 送信するデータ。キーは'data'、値はinputVの値
      success: function() {
        // 送信が成功した場合の処理
        console.log(data); // レスポンスデータをコンソに表示
        console.log(clientId);
      },
      error: function(xhr, status, error) {
        // 送信が失敗した場合の処理
        console.error(xhr); // エラー内容をコンソールに表示
      }
    });
    location.reload();
    // return false;
  });
});

