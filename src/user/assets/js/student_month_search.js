$(document).ready(function() {
  $('#search_btn').click(function() {
    var month = $('[name=month]').val();
    var year = $('[name=year]').val(); // input要valueを取
    var data=year+month;
    console.log(month);
 
   $.ajax({
      url: 'http://localhost:8080/admin/search_student.php', // 送信先のPHPファイルのパス
      type: 'POST',
      data: {
        data:data

      }, // 送信するデータ。キーは'inputVal'、値はinputVの値
      success: function(data) {
        // 送信が成功した場合の処理
        console.log(data);
       // レスポンスデータをコンソに表示
      },
      error: function(xhr, status, error) {
        // 送信が失敗した場合の処理
        console.error(xhr); // エラー内容をコンソールに表示
      }
    });
    location.reload();
  });
});
