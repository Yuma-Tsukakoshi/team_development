<?php
require_once(dirname(__FILE__) . './../dbconnect.php');

session_start();
$pdo=Database::get();
print_r($_SESSION['products']);



$agent = isset($_POST['client_id'])? htmlspecialchars($_POST['client_id'], ENT_QUOTES, 'utf-8') : '';



if($agent!=''){
  $_SESSION['products']=[
              'agent' => $agent
        ];   
}
//$products=$_SESSION['products'];
//$num=count($_SESSION['products']);

header('Content-type:application/json; charset=utf8');

echo json_encode(count($_SESSION['products']));
?>
