<?php
 require_once(dirname(__FILE__) . './../dbconnect.php');

 session_start();
 $pdo=Database::get();


 $id=$_POST['id'];
 $clients=$_SESSION['clients'];
 
 if($id!=''){
  unset($_SESSION['clients'][$id]);
 }

 header('Content-type:application/json; charset=utf8');

 echo json_encode($_POST['id']);
 ?>