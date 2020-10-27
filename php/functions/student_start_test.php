<?php
session_start();
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
$selector = rand(1,5);
$i = 0;
$_SESSION['MODULE'] = $test_name;
echo "<form action='complete_test.php' method='POST'>";
$showmeta = true;
foreach ($json_a as $struct => $quest) {
  if($showmeta){
    $showmeta=false;
    echo "
    <p> Название модуля: ". $quest['Module_name'] ." </p>
    <p> Кол-во вопросов: ".$quest['quest_quantity']."</p>
    ";
    continue;
  }
  if($quest['QUESTION_NUM'] == "$qselector"){
    if($quest['VAR'] == "$selector"){
        $selector = rand(1,5);
        $_SESSION["QUESTION_$qselector"] = $quest['QUESTION'];
        $_SESSION["QUESTION_VAR_$qselector"] = $quest['VAR'];
        $_SESSION["CORRECT_ANSW_$qselector"] = $quest['CORRECT'];
        echo
          "<div class='task' id='n" . $quest['QUESTION_NUM'] . "-v" . $quest['VAR'] . "'>
          <h4 class='tests' style='border-radius: 15px;'> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . "
          </h4> <p style='color: #606060;'>" .  $quest['QUESTION'] . " <br>
          A) " . $quest['A'] . " ;
          B) " . $quest['B'] . " ;
          C) " . $quest['C'] . " ;
          D) " . $quest['D'] . "</p>
          <br> <input name='ANSW_$qselector' type='text' class='answer' placeholder='Ваш ответ'>
          <hr> </div>";
          $qselector++;
      }
    }
  }
  $_SESSION['QUESTIONS_QUANTITY'] = $qselector;
  echo "
  <button> Завершить тест </button>
  </form>
  ";

?>
