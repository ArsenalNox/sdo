<?php
include_once "dtb/dtb.php";
if(!($_SERVER['REQUEST_METHOD'] == 'POST')){
  header("Location: index.php");
}
session_start();
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/student.css">
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

<?php
  $student = $_SESSION['UID'];
  $module_name = $_SESSION['MODULE'];
  $correct_answers = 0;
  echo " <section class='student-wrapper'>
  <fieldset class='fieldset'>
  Результаты теста, " .$student ;
  for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']; $i++) {
    $variant = $_SESSION["QUESTION_VAR_$i"];
    $question_text = $_SESSION["QUESTION_$i"];
    $question_answer_given = $_POST["ANSW_$i"];
    $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
    echo "
    <div class='question-result'>
      <p> Номер вопроса $i</p>
      <p> Текст вопрос: $question_text</p>
      ";
    if(strcasecmp($question_answer_given,$question_answer_correct) == 0){
      echo "
      <p> Вы ответели '$question_answer_given'. </p>
      <p> Ваш ответ правильный! </p>
      ";
      $_SESSION["STATE_$i"] = 1;
      $correct_answers++;
    } else {
      echo "
      <p>Вы ответили '$question_answer_given'. </p>
      <p> Ваш ответ не правильный! Правильный ответ - '$question_answer_correct' </p>";
      $_SESSION["STATE_$i"] = 0;
    }
    echo "</div>";
  }
  //Writing to DB
  $sql = "SELECT * FROM test_results WHERE student = '$student' AND module='$module_name';";
  $check = mysqli_query($conn, $sql);

  if($correct_answers == 0){
    $percent = "0%";
  } else {
    $percent = round($_SESSION['QUESTIONS_QUANTITY']/$correct_answers*10) . "%";
  }

  if($check){
    if(mysqli_num_rows($check) == 0){
      for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']; $i++) {
        $variant = $_SESSION["QUESTION_VAR_$i"];
        $question_text = $_SESSION["QUESTION_$i"];
        $question_answer_given = $_POST["ANSW_$i"];
        $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
        $array_to_record[] = array($question_text, $variant,$question_answer_correct, $question_answer_given);
      }
      $today = date("Y-m-d H:i:s");
      $group = $_SESSION['GROUP_UID'];
      //Check if answer result exists (for future expansion)
      if(isset($_SESSION["STATE_1"])){$q1 = $_SESSION["STATE_1"];}
      if(isset($_SESSION["STATE_2"])){$q2 = $_SESSION["STATE_2"];}
      if(isset($_SESSION["STATE_3"])){$q3 = $_SESSION["STATE_3"];}
      if(isset($_SESSION["STATE_4"])){$q4 = $_SESSION["STATE_4"];}
      if(isset($_SESSION["STATE_5"])){$q5 = $_SESSION["STATE_5"];}
      if(isset($_SESSION["STATE_6"])){$q6 = $_SESSION["STATE_6"];}
      if(isset($_SESSION["STATE_7"])){$q7 = $_SESSION["STATE_7"];}
      if(isset($_SESSION["STATE_8"])){$q8 = $_SESSION["STATE_8"];}
      $sql = "INSERT INTO `test_results`(`student`, `class`, `date`, `module`, `percent`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`) VALUES (
        '$student',
        '$group',
        '$today',
        '$module_name',
        '$percent',
        '$q1',
        '$q2',
        '$q3',
        '$q4',
        '$q5',
        '$q6',
        '$q7'
      )";
      $result = mysqli_query($conn, $sql);
      echo "
      $sql
      <p> Ваш результат был сохранён! </p>
      ";
    }
  }

  echo "<br>
  <p> Вы ответели правильно на " .$percent. " </p>
  <a class='home' href='index.php'> Вернутся на главную </a></fieldset> </section>";
 ?>
  </body>
</html>
