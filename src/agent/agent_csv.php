<?php
session_start();
require_once(dirname(__FILE__) . '/../dbconnect.php');
$pdo = Database::get();
$sql="SELECT * FROM clients WHERE client_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_SESSION["id"]);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);

$month=date('m');

function putCsv($data,$month,$client) {

    try {

        //CSV形式で情報をファイルに出力のための準備
        $csvFileName = '/tmp/' . time() . rand() . '.csv';
        //$fileName = time() . rand() . '.csv';
        $fileName= $month. '月'. $client['agent_name'].'申請学生一覧'. '.csv';
        $res = fopen($csvFileName, 'w');
        if ($res === FALSE) {
            throw new Exception('ファイルの書き込みに失敗しました。');
        }

        // 項目名先に出力
        $header = ["id", "name", "hurigana", "sex", "birthday", "college", "faculty", "department", "division", "grad_year", "prefecture", "mail", "phone"];
        fputcsv($res, $header);

        // ループしながら出力
        foreach($data as $dataInfo) {
            // 文字コード変換。エクセルで開けるようにする
            mb_convert_variables('SJIS', 'UTF-8', $dataInfo);

            // ファイルに書き出しをする
            fputcsv($res, $dataInfo);
        }

        // ファイルを閉じる
        fclose($res);

        // ダウンロード開始

        // ファイルタイプ（csv）
        header('Content-Type: application/octet-stream');

        // ファイル名
        header('Content-Disposition: attachment; filename=' . $fileName); 
        // ファイルのサイズ　ダウンロードの進捗状況が表示
        header('Content-Length: ' . filesize($csvFileName)); 
        header('Content-Transfer-Encoding: binary');
        // ファイルを出力する
        readfile($csvFileName);

    } catch(Exception $e) {

        // 例外処理をここに書きます
        echo $e->getMessage();

    }
}


/*ログインしているクライアントかつ今月申請かつ無効申請されていない学生取得*/
$sql = "SELECT users.name,users.hurigana,users.sex,users.birthday,users.college,users.faculty,users.department,users.division,users.grad_year,users.prefecture,users.mail,users.phone FROM users INNER JOIN user_register_client AS r ON users.id = r.user_id WHERE r.client_id = :id && users.is_valid = 1 && DATE_FORMAT(users.updated_at, '%Y%m') = DATE_FORMAT(NOW(), '%Y%m')  ORDER BY updated_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $_SESSION["id"]);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

//表示用のidを追加
$array=[];
foreach($users as $id => $user){
  $user=array('id'=> $id +1) + $user;
  array_push($array,$user);
}
putCsv($array,$month,$client);
