<?php
require_once(dirname(__FILE__) . '/../../dbconnect.php');
$pdo = Database::get();

$sql = "UPDATE users SET 
name=:name,hurigana =:hurigana ,sex =:sex, birthday=:birthday,mail=:mail,phone =:phone,prefecture =:prefecture,college =:college,
faculty=:faculty,department =:department ,division =:division,grad_year=:grad_year
WHERE id = :id";

$params = [
  "id" => $_POST["id"],
  "name"=>$_POST["name"],
  "hurigana"=>$_POST["hurigana"],
  "sex"=>$_POST["sex"],
  "birthday"=>$_POST["birthday"],
  "mail"=>$_POST["mail"],
  "phone"=>$_POST["phone"],
  "prefecture"=>$_POST["prefecture"],
  "college"=>$_POST["college"],
  "faculty"=>$_POST["faculty"],
  "department"=>$_POST["department"],
  "division"=>$_POST["division"],
  "grad_year"=>$_POST["grad_year"],
];

$pdo->beginTransaction();
try {
  $stmt = $pdo->prepare($sql);
  $result = $stmt->execute($params);
  $pdo->commit();
  header("Location: " . "http://localhost:8080/admin/boozer_student.php");
} catch (Error $e) {
  $pdo->rollBack();
}
