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
$_SESSION['MODULE'] = $test_name;
$showmeta = true;
$vars = 1;
foreach ($json_a as $struct => $quest) {
  if($showmeta){
    $showmeta=false;
    if(isset($quest['quest_vars'])){
      $vars = $quest['quest_vars'];
    } else {
      $vars = 1;
    }
    echo "
    <p> <button onclick='stopTest()'> Прекратить выполнение теста </button> </p>
    <p> Название модуля: ". $quest['Module_name'] ." </p>
    <p> Кол-во вопросов: ".$quest['quest_quantity']."</p>
    <p> Время на выполнение: ".$time_to_complete." минут</p>
    ";
    echo "<form action='complete_test.php' method='POST' id='tfs1'>";
    continue;
  }
  if($quest['QUESTION_NUM'] == "$qselector"){
  	if($quest['VAR'] == "$selector"){
          if($vars>1){
            $selector = rand(1,$vars);
          }else {
            $selector = 1;
          }
          $_SESSION["QUESTION_$qselector"] = $quest['QUESTION'];
          $_SESSION["QUESTION_VAR_$qselector"] = $quest['VAR'];
          $_SESSION["CORRECT_ANSW_$qselector"] = $quest['CORRECT'];
          echo "
          <div class='task' id='n" . $quest['QUESTION_NUM'] . "'>
          <h4 class='tests' style='border-radius: 15px;' id='num$qselector'> Задание №" . $quest['QUESTION_NUM'] ."</h4>";
          if($quest['IMAGE'] !== ''){
              echo "<img src='".$quest['IMAGE']."' >";
              $_SESSION["QUESTION_IMAGE_$qselector"] = $quest['IMAGE'];
          } else {
            $_SESSION["QUESTION_IMAGE_$qselector"] = '';
          }
          if(isset($quest['TYPE']) ){
            switch ($quest['TYPE']) {
            // TODO: Переписать вывод кол-ва вопросов в зависимости от их наличия в json, что убирает необходимость в NUM_ANSW (if isset)
                //С открытым ответом
                case 'open':
                  echo "<p style='color: #606060;'>" .  $quest['QUESTION'] . " <br> ";
                  if(isset($quest['NUM_ANSW'])){
                    switch ($quest['NUM_ANSW']) {
                      case '4':
                          echo "
                          A) " . $quest['A'] . "
                          B) " . $quest['B'] . "
                          C) " . $quest['C'] . "
                          D) " . $quest['D'] . "</p>";
                        break;
                      case '2':
                          echo "
                          A) " . $quest['A'] . "
                          B) " . $quest['B'] . "
                          </p>";
                        break;
                    }
                  } else {
                    echo "
                    A) " . $quest['A'] . "
                    B) " . $quest['B'] . "
                    C) " . $quest['C'] . "
                    D) " . $quest['D'] . "</p>";
                  }
                  echo "
                  <br> <input name='ANSW_$qselector' type='text' class='answer' placeholder='Ваш ответ'>
                  <hr> </div>";
                  break;

                //С выбором ответа
                case 'choose-answer':
                  echo "<p style='color: #606060;'>" .  $quest['QUESTION'] . " </p> <br>";
                  if(isset($quest['NUM_ANSW'])){
                    switch ($quest['NUM_ANSW']) {
                      case '4':
                          echo "
                          <input type='radio' id='A$qselector' name='ANSW_$qselector' value='".$quest['A']."'> <label for='A$qselector'> A) ".$quest['A']." </label> <br>
                          <input type='radio' id='B$qselector' name='ANSW_$qselector' value='".$quest['B']."'> <label for='B$qselector'> B) ".$quest['B']." </label> <br>
                          <input type='radio' id='C$qselector' name='ANSW_$qselector' value='".$quest['C']."'> <label for='C$qselector'> C) ".$quest['C']." </label> <br>
                          <input type='radio' id='D$qselector' name='ANSW_$qselector' value='".$quest['D']."'> <label for='D$qselector'> D) ".$quest['D']." </label> <br>
                          <hr> </div>";
                        break;
                      case '2':
                          echo "
                          <input type='radio' id='A$qselector' name='ANSW_$qselector' value='".$quest['A']."'> <label for='A$qselector'> A) ".$quest['A']." </label> <br>
                          <input type='radio' id='B$qselector' name='ANSW_$qselector' value='".$quest['B']."'> <label for='B$qselector'> B) ".$quest['B']." </label> <br>
                          <br>
                          <hr> </div>";
                        break;
                  }}else {
                    echo "
                    <input type='radio' id='A$qselector' name='ANSW_$qselector' value='".$quest['A']."'> <label for='A$qselector'> A) ".$quest['A']." </label> <br>
                    <input type='radio' id='B$qselector' name='ANSW_$qselector' value='".$quest['B']."'> <label for='B$qselector'> B) ".$quest['B']." </label> <br>
                    <input type='radio' id='C$qselector' name='ANSW_$qselector' value='".$quest['C']."'> <label for='C$qselector'> C) ".$quest['C']." </label> <br>
                    <input type='radio' id='D$qselector' name='ANSW_$qselector' value='".$quest['D']."'> <label for='D$qselector'> D) ".$quest['D']." </label> <br>
                    <br>
                    <hr> </div>";
                  }
                  break;

              }
            } else {
              echo "<p style='color: #606060;'>" .  $quest['QUESTION'] . " <br>
              A) " . $quest['A'] . "
              B) " . $quest['B'] . "
              C) " . $quest['C'] . "
              D) " . $quest['D'] . "</p>
              <br> <input name='ANSW_$qselector' type='text' class='answer' placeholder='Ваш ответ'>
              <hr> </div>";
            }
            $qselector++;
        }
      }
  }
  $_SESSION['QUESTIONS_QUANTITY'] = $qselector;
  echo "
  </form>
  <input type='hidden' name='time_to_complete' id='ttc' value='time_to_complete'>
  <input type='hidden' name='newtitle' id='ntl' value='$test_name'>
  ";
?>
