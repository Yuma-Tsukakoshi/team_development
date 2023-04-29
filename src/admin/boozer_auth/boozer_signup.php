<h1>新規会員登録</h1>
<form action="boozer_register.php" method="post">//処理を行う宛先を指定
<div>
    <label>
        名前：
        <input type="text" name="name" required>
    </label>
</div>
<div>
    <label>
        メールアドレス：
        <input type="text" name="mail" required>
    </label>
</div>
<div>
    <label>
        パスワード：
        <input type="password" name="pass" required>
    </label>
</div>
<input type="submit" value="新規登録">
</form>
<p>すでに登録済みの方は<a href="boozer_login.php">こちら</a></p>