<?php
// require_once(dirname(__FILE__) . '/../../dbconnect.php');

//フォームからの値をそれぞれ変数に代入
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$dsn = "mysql:host=db; dbname=shukatsu; charset=utf8";
$username = "root";
$password = "root";
try {
  $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  $msg = $e->getMessage();
}

//フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM boozer_register_client WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
if ($member['mail'] === $mail) {
  $msg = '同じメールアドレスが存在します。';
  $link = '<a href="boozer_signup.php">戻る</a>';
} else {
  //登録されていなければinsert 
  $sql = "INSERT INTO boozer_register_client(name, mail, password) VALUES (:name, :mail, :password)";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":name", $name);
  $stmt->bindValue(":mail", $mail);
  $stmt->bindValue(":password", $pass); // passwordの値を追加
  $stmt->execute();
  $msg = '会員登録が完了しました';
  $link = '<a href="boozer_login.php">ログインページ</a>';
}
?>

<h1><?php echo $msg; ?></h1><!--メッセージの出力-->
<?php echo $link; ?>
