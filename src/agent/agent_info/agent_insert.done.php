<?php
require_once(dirname(__FILE__) . './../../dbconnect.php');

session_start();
$pdo=Database::get();
try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare('SELECT MAX(client_id)+1 FROM clients');
  $stmt->execute();
  $id=$stmt->fetch(PDO::FETCH_ASSOC);
  
  $stmt = $pdo->prepare("INSERT INTO clients(client_id,agent_name,service_name,catchphrase,recommend_point1,recommend_point2,recommend_point3,started_at,ended_at,logo_img) VALUES(:client_id,:agent_name,:service_name,:catchphrase,:recommend_point1,:recommend_point2,:recommend_point3,:started_at,:ended_at,:logo_img)");
  $stmt->execute([
    "client_id" => $id["MAX(client_id)+1"],
    "agent_name" => $_POST["agent_name"],
    "service_name" => $_POST["service_name"],
    "catchphrase" => $_POST["catchphrase"],
    "recommend_point1" => $_POST["recommend_point1"],
    "recommend_point2" => $_POST["recommend_point2"],
    "recommend_point3" => $_POST["recommend_point3"],
    "started_at" => $_POST["started_at"],
    "ended_at" => $_POST["ended_at"],
    "logo_img" => $_POST["logo_img"],
  ]);
  
  $client_id = $pdo -> lastInsertId();
  

  $stmt = $pdo->prepare("INSERT INTO managers(client_id,manager,depart,mail,phone) VALUES(:client_id,:manager,:depart,:mail,:phone)");
  $params2 = [
    "client_id" => $client_id,
    "manager" => $_POST["manager"],
    "depart" => $_POST["depart"],
    "mail" => $_POST["mail"],
    "phone" => $_POST["phone"],
  ];
  $stmt->execute($params2);
  
  if($_POST['subject'][0]==0){
    $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES($client_id,1),($client_id,2)");
    $stmt->execute();
   
  }else{
    $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES(:client_id,:label_id)");
    $params3 = [
      "client_id" => $client_id,
      "label_id" => $_POST["subject"][0],
    ];
    $stmt->execute($params3);

  }
  

  foreach($_POST['contact'] as $data){
    $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES(:client_id,:label_id)");
    $params4 = [
      "client_id" => $client_id,
      "label_id" => $data,
    ];
    $stmt->execute($params4);

  }

  if (isset($_POST['place']) && is_array($_POST['place'])) {
    foreach($_POST['place'] as $data){
      $stmt = $pdo->prepare("INSERT INTO label_client_relation(client_id,label_id) VALUES(:client_id,:label_id)");
      $params5 = [
        "client_id" => $client_id,
        "label_id" => $data,
      ];
      $stmt->execute($params5);
  
    }
    
  }
  
  //emailは登録に入らない？
  $stmt = $pdo->prepare("INSERT INTO client_login(client_id,password) VALUES(:client_id,:password)");
  $params6 = [
    "client_id" => $client_id,
    "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
  ];
  $stmt->execute($params6);


  
    
  $pdo->commit();

  //header("Location: " . "http://localhost:8080/admin/boozer_index.php");


}catch(\Exception $e){
  $pdo->rollBack();
  exit($e->getMessage());
}



?>