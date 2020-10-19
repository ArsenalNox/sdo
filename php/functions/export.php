<?php

$user = 'root';
$password = '';
$server = 'localhost';
$database = 'sdo';
$pdo = new PDO("mysql:host=$server;dbname=$database", $user, $password);

//Все используют для этого пдо так что и я буду использовать пдо
$sql = 'SELECT * FROM test_results';
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filename = 'результаты.xls';
//Параметры для браузера
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
$separator = "\t";

if(!empty($rows)){
    //Первые линии - названия
    echo implode($separator, array_keys($rows[0])) . "\n";
    foreach($rows as $row){
        //Почистить символы в ряду и занести из
        foreach($row as $k => $v){
            $row[$k] = str_replace($separator . "$", "", $row[$k]);
            $row[$k] = preg_replace("/\r\n|\n\r|\n|\r/", " ", $row[$k]);
            $row[$k] = trim($row[$k]);
        }
        //Эхо получившийся таблицы
        echo implode($separator, $row) . "\n";
    }
}
?>
