<?php

require_once(dirname(__FILE__) . '/../../dbconnect.php');

session_start();
$_SESSION = array();//セッションの中身をすべて削除
session_destroy();//セッションを破壊

header('Location: http://localhost:8080/agent/agent_auth/agent_login.php');
exit();
?>
