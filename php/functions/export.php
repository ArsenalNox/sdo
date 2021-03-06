<?php
session_start();

$user = 'root';
$password = '';
$server = 'localhost';
$database = 'sdo';

if(!isset($_SESSION['sql'])){
  switch ($_POST['export_option']) {
    case 'all_all':
        $sql = 'SELECT id, date, module, percent FROM test_results LIMIT 500';
        $filename = 'результаты_за_всё_время.xls';
      break;

    case '04_02_2021':
      // $sql = 'SELECT * FROM test_results LIMIT 500';
      $sql = 'SELECT id, student, module FROM test_results';
      $filename = '123.xls';
      break;

    case 'all_time':
        $date_start = $_POST['first_date'];
        $date_end = $_POST['second_date'];
        $sql = "SELECT id, date, module, percent FROM test_results, WHERE date >= '$date_start' and date <= '$date_end' LIMIT 500";
        $filename = "результаты_за_$date_start-$date_end.xls";
      break;

    case 'spec_all':
        $group = $_POST['group'];
        $sql = "SELECT id, date, module, percent FROM test_results WHERE class = '$group' LIMIT 500";
        $filename = "результаты_класса_$group.xls";
      break;

    default:
        $sql = 'SELECT id, date, module, percent FROM test_results LIMIT 500';
        $filename = 'результаты_за_всё_время.xls';
      break;
  }
} else {
  $sql = $_SESSION['sql'];
  $filename = 'таблица_результатов.xls';
}


$pdo = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $user, $password);
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(!$rows){
    echo "Произошла ошибка! Повторите запрос!";
}

//Параметры для браузера
// header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
$separator = "\t";

if(!empty($rows)){
    $lastRow = 0;
    $qcount = 0;
    for($i = 0; $i < count($rows); $i++)
    {
        // $row = [];
        //Почистить символы в ряду и занести из
        foreach($rows[$i] as $k => $v){
            if($k != 'id')
            {
              $rows[$i][$k] = str_replace($separator . "$", "", $rows[$i][$k]);
              $rows[$i][$k] = preg_replace("/\r\n|\n\r|\n|\r/", " ", $rows[$i][$k]);
              $rows[$i][$k] = trim($rows[$i][$k]);
              $rows[$i][$k] = mb_convert_encoding($rows[$i][$k], 'Windows-1251');
              $row[$k] = $rows[$i][$k];
            }
        }

        if($_POST['export_option'] == '04_02_2021')
        {
          $sql_ = "SELECT id, Question_var, Correctness FROM tr_".$rows[$i]['id'];
          $stmt_ = $pdo->query($sql_);
          $rows_ = $stmt_->fetchAll(PDO::FETCH_ASSOC);
          foreach($rows_ as $row_)
          {
            if($i==0){$qcount++;}
            $row[mb_convert_encoding('задание '.$row_['id'].' вариант', 'Windows-1251')] = $row_['Question_var'];
            if($row_['Correctness'] == '1')
            {
              $row[mb_convert_encoding('задание '.$row_['id'], 'Windows-1251')] = mb_convert_encoding('Да', 'Windows-1251');
            }
            else
            {
              $row[mb_convert_encoding('задание '.$row_['id'], 'Windows-1251')] = mb_convert_encoding('Нет', 'Windows-1251');
            }
          }
          //TODO:ВОТ ТУТ ВОТ ДОЛЖНО БЫТЬ СОСТАВЛЕНИЕ ОСТАЛЬНЫХ ТРЕБОВАНИЙ МИНИСТРА 
        }
        if($i == 0)
        {
          //Первые линии - названия
          echo implode($separator, array_keys($row)) . "\n";
        }
        //Эхо получившийся строки
        echo implode($separator, $row) . "\n";
        $lastRow=$i;

    }
    for($i=0; $i<3; $i++){
       echo " \n ";
    } //Отступ от последней строки
    echo mb_convert_encoding("Макс кол-во заданий: $qcount", 'Windows-1251') . "\n";
    echo mb_convert_encoding("Тест 1\t Тест 2", 'Windows-1251');
}
?>
