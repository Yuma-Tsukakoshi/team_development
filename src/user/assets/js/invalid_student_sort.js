$(document).ready(function() {
  $('#sort_btn').click(function() {
    var inputVal = $('#sort-by').val(); // input要valueを取
    console.log(inputVal);
    // ↑正しい値は取って来れている
    $.ajax({
      url: 'http://localhost:8080/admin/invalid_sort_student.php', // 送信先のPHPファイルのパスもあってる
      type: 'POST',
      data: {
        input: inputVal
      }, // 送信するデータ。キーは'inputVal'、値はinputVの値

      success: function(data) {
        // 送信が成功した場合の処理
        // 成功してるけどHTMLが返される正しくない
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

