$('#otherInput').hide();

// ラジオボタンの変更を監視
$('input[type="radio"]').change(function() {
  // 「その他」が選択された場合、テキスト入力フィールドを表示
  if ($(this).val() === 'other' && $(this).is(':checked')) {
    $('#otherInput').fadeIn();
  } else {
    $('#otherInput').fadeOut(500);
  }
});
