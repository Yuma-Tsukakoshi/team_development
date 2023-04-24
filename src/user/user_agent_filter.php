<?php

require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();
$agents = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // チェックボックスから受信した値を取得
    $filters = $_POST['filter'];
    // 絞り込みを行うSQLクエリを作成
    $query = "SELECT * FROM clients AS main INNER JOIN (SELECT DISTINCT sub.client_id FROM clients AS sub INNER JOIN label_client_relation ON sub.client_id=label_client_relation.client_id WHERE";
    foreach($filters as $index => $filter) {
        if($index > 0) {
            $query .= " OR";
        }
        $query .= " label_id = $filter";
    }
    $query .= ") AS sub ON main.client_id=sub.client_id";
    // クエリを実行する
    $statement = $pdo->query($query);
    $agents = $statement->fetchAll();
}else{
  $agents = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);
}

?>
