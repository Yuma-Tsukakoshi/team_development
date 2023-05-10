<?php
require_once(dirname(__FILE__) . './../../dbconnect.php');

session_start();
$pdo=Database::get();
// POSTで送信されたデータを取得する
$mail = isset($_POST['mail']) ? $_POST['mail'] : null;
$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

// メールアドレスをキーにしてユーザー情報を取得する
$sql = "SELECT * FROM client_login INNER JOIN managers ON client_login.client_id=managers.client_id  WHERE mail = :mail";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($member);
// パスワードの比較時にnullが渡されないように、$passがnullの場合は認証エラーとする
if (!$member || !$pass || !password_verify($pass, $member['password'])) {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="http://localhost/:8080/agent/agent_auth/agent_login.php">戻る</a>';
    } else {
  // 認証に成功した場合は、セッションにユーザー情報を保存する
    $_SESSION['id'] = $member['client_id'];
    $_SESSION['name'] = $member['manager'];
    $msg = 'ログインしました。';
    $link = '<a href="http://localhost:8080/agent/agent_boozer.php?id=' + $member['client_id'] +'>ホーム</a>';
    }
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>*/
