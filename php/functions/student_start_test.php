<?php
//Начало тестов
include_once "../../dtb/dtb.php";
//Загрузка данных из таблицы текущего теста
$test_id = $_POST['test_id'];
$sql = "SELECT * FROM current_test WHERE id ='$test_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$test_name = $row['test_dir'];
$test_subject = $row['subject'];
$class = $row['group_to_test'];
$time_to_complete = $row['time_to_complete'];
echo "$test_subject, $test_name, $time_to_complete, $class";
  //Загрузка данных о самом тесте
  $sql = "SELECT * FROM new_module WHERE Name = '$test_name'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $path = $row['Questions'];
  $string = file_get_contents("../../$path");
  $json_a = json_decode($string, true);
  $qselector = 1;
  $selector = 1;
  $i = 0;
  foreach ($json_a as $struct => $quest) {
    if($quest['QUESTION_NUM'] == "$qselector"){
      if($quest['VAR'] == "$selector"){
          $selector = rand(1,5);
          $qselector++;
          echo
            "<div class='task' id='n" . $quest['QUESTION_NUM'] . "-v" . $quest['VAR'] . "'>
            <h4> Задание №" . $quest['QUESTION_NUM'] . "
            Вариант " . $quest['VAR'] . "
            </h4> " . $quest['QUESTION'] . " <br>
            A) " . $quest['A'] . " ;
            B) " . $quest['B'] . " ;
            C) " . $quest['C'] . " ;
            D) " . $quest['D'] . "
            <br> <input placeholder='Ваш ответ'>
            <hr> </div>";
          
        }
      }
    }
    echo "<button> Завершить тест </button>";
?>
