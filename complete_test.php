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
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<?php
  $student = $_SESSION['UID'];
  $module_name = $_SESSION['MODULE'];
  echo " <section class='student-wrapper'> Результаты теста, " . $student;
  for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']; $i++) {
    $variant = $_SESSION["QUESTION_VAR_$i"];
    $question_text = $_SESSION["QUESTION_$i"];
    $question_answer_given = $_POST["ANSW_$i"];
    $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
    echo "
    <div class='question-result'>
      <p> Номер вопроса $i, вариант $variant </p>
      <p> Текст вопрос: $question_text</p>
      ";
    if(strcasecmp($question_answer_given,$question_answer_correct) == 0){
      echo "<p>Вы ответели '$question_answer_given' Ваш ответ правилный!</p>";
      $_SESSION["STATE_$i"] = 1;
    } else {
      echo "<p>Вы ответили '$question_answer_given' Ваш ответ не правильный! Правильный ответ $question_answer_correct </p>";
      $_SESSION["STATE_$i"] = 0;
    }
    echo "</div>";
  }
  //Writing to DB
  $sql = "SELECT * FROM test_results WHERE student = '$student' AND module='$module_name';";
  $check = mysqli_query($conn, $sql);
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

    $q1 = $_SESSION["STATE_1"];
    $q2 = $_SESSION["STATE_2"];
    $q3 = $_SESSION["STATE_3"];
    $q4 = $_SESSION["STATE_4"];
    $q5 = $_SESSION["STATE_5"];
    $q6 = $_SESSION["STATE_6"];
    $q7 = $_SESSION["STATE_7"];

    $sql = "INSERT INTO `test_results`(`student`, `class`, `date`, `module`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`) VALUES (
      '$student',
      '$group',
      '$today',
      '$module_name',
      '$q1',
      '$q2',
      '$q3',
      '$q4',
      '$q5',
      '$q6',
      '$q7'
    )";
    $result = mysqli_query($conn, $sql);
    echo "Ваш результат быо записан!";
  }
  echo "<br> <a href='index.php'> Вернутся на главную </a> </section>";
 ?>

  </body>
</html>
