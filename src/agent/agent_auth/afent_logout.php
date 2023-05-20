<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');

session_start();
$_SESSION = array();//セッションの中身をすべて削除
session_destroy();//セッションを破壊
?>

<p>ログアウトしました。</p>
<a href="agent_login.php">ログインへ</a>