<?php
session_start();
if (isset($_SESSION['id'])) {//ログインしているとき
    $username = $_SESSION['name'];
    $msg = 'こんにちは' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さん';
    $link = '<a href="boozer_logout.php">ログアウト</a>';
} else {//ログインしていない時
    $msg = 'ログインしていません';
    $link = '<a href="http://localhost:8080/admin/boozer_auth/boozer_login.php">ログイン</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>
