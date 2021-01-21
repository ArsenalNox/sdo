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

$_SESSION['MODULE'] = $test_name;
$_SESSION['TEST_SUBJECT'] = $test_subject;
$_SESSION['TEST_ID'] = $row['id']; 
$qselector = 1;
$selector = 1;
$i = 0;
$showmeta = true;
$vars = 1;
// TODO: Глобальный таймер для ученика на выполнение теста
// TODO: Получение значения и запоминание типа/подтипа вопроса
foreach ($json_a as $struct => $quest) {
  if($showmeta){
    $showmeta=false;
    if(isset($quest['quest_vars'])){
      $vars = $quest['quest_vars'];
    } else {
      $vars = 1;
    }
    echo "
    <p> Название модуля: ". $quest['Module_name'] ." </p>
    <p> Кол-во вопросов: ".$quest['quest_quantity']."</p>
    <p> Время на выполнение: ".$time_to_complete." минут</p>
    <div class='timer-wrap'> <p> Оставшееся время на выполнение: <span id='timer'> </span> </p> </div>
    <input type='hidden' name='time_to_complete' id='ttc' value='$time_to_complete'>
    <input type='hidden' name='newtitle' id='ntl' value='$test_name'>
    <hr>
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
	  if(isset($quest['QUESTION_TYPE'])){
	  	$_SESSION["Question_type_$i"] = $quest['QUESTION_TYPE'];
	  } else $_SESSION["Question_type_$i"] = '';
	  if(isset($quest['QUESTION_SUBTYPE'])){
	  	$_SESSION["Question_subtype_$i"] = $quest['QUESTION_SUBTYPE'];
	  } else $_SESSION["Question_subtype_$i"] = '';
	  if(isset($quest['QUESTION_SUBTYPE'])){
	  	$_SESSION["Question_commentary_$i"] = $quest['QUESTION_COMMENTARY'];
	  } else $_SESSION["Question_commentary_$i"] = '';
    echo "
          <div class='task' id='n" . $quest['QUESTION_NUM'] . "'>
          <h4 class='tests' style='border-radius: 15px;' id='num$qselector'> Задание №" . $quest['QUESTION_NUM'] ."</h4>";
          if($quest['IMAGE'] !== ''){
              echo "<img src='/sdo/".$quest['IMAGE']."' >";
              $_SESSION["QUESTION_IMAGE_$qselector"] = $quest['IMAGE'];
          } else {
            $_SESSION["QUESTION_IMAGE_$qselector"] = '';
          }
		echo "<p style='color: #606060;' class='font'>" .  $quest['QUESTION'] . " </p> <br>";
		  if(isset($quest['A'])){
			echo "<input type='radio' id='A$qselector' name='ANSW_$qselector' value='".$quest['A']."' required> <label for='A$qselector'> A) ".$quest['A']." </label> <br>"; 
		  }		  
		  if(isset($quest['B'])){
			echo "<input type='radio' id='B$qselector' name='ANSW_$qselector' value='".$quest['B']."' required> <label for='B$qselector'> B) ".$quest['B']." </label> <br>"; 
		  }
		  if(isset($quest['C'])){
			echo "<input type='radio' id='C$qselector' name='ANSW_$qselector' value='".$quest['C']."' required> <label for='C$qselector'> C) ".$quest['C']." </label> <br>"; 
		  }
		  if(isset($quest['D'])){
			echo "<input type='radio' id='D$qselector' name='ANSW_$qselector' value='".$quest['D']."' required> <label for='D$qselector'> D) ".$quest['D']." </label> <br>"; 
		  }
		  if(isset($quest['E'])){
			echo "<input type='radio' id='E$qselector' name='ANSW_$qselector' value='".$quest['E']."' required> <label for='E$qselector'> E) ".$quest['E']." </label> <br>"; 
		  }
		echo "<hr> </div>";

            $_SESSION['QUESTIONS_QUANTITY'] = $qselector;
            $qselector++;
        }
      }
  }
echo "
</form>
";

?>

