<?php
 require_once(dirname(__FILE__) . './../dbconnect.php');

 session_start();
 $pdo=Database::get();

 $agent = isset($_POST['client_id'])? htmlspecialchars($_POST['client_id'], ENT_QUOTES, 'utf-8') : '';
 $id=$_POST['id'];
 $key=(int)$agent;



if($agent!=''){
    $_SESSION['clients'][$key]=[
          'agent' => $agent
      ];   
}
 //$products=$_SESSION['products'];
 //$num=count($_SESSION['products']);

 header('Content-type:application/json; charset=utf8');

 echo json_encode(count($_SESSION['clients']));
 ?>