<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $count = $_POST['count']; // 'value'はPOSTされたデータのキーになります
    // 受け取った$valueを処理する
    print_r($count);
}
?>
