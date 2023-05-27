<?php
// エラー出力の設定
ini_set('display_errors', "On");

// POSTで送信されたデータを取得する
$mail = isset($_POST['mail']) ? $_POST['mail'] : null;
$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

// データベースに接続する
$dsn = "mysql:host=db; dbname=shukatsu; charset=utf8";
$username = "root";
$password = "root";

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

// ヘッダーの送信前にsession_start()を呼び出す
session_start();

// メールアドレスをキーにしてユーザー情報を取得する
$sql = "SELECT * FROM boozer_register_client WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
// パスワードの比較時にnullが渡されないように、$passがnullの場合は認証エラーとする
if (!$member || !$pass || !password_verify($pass, $member['password'])) {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="http://localhost:8080/admin/boozer_auth/boozer_login.php">戻る</a>';
    } else {
  // 認証に成功した場合は、セッションにユーザー情報を保存する
  header('Location: http://localhost:8080/admin/boozer_index.php');
exit();
    // $_SESSION['id'] = $member['id'];
    // $_SESSION['name'] = $member['name'];
    // $msg = 'ログインしました。';
    // $link = '<a href="http://localhost:8080/admin/boozer_index.php">ホーム</a>';
    }
?>

<!-- cssつけてもよい -->
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>
