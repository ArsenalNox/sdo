<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/student.css">
    <title> Результат теста </title>
  </head>
  <body>
<?php
//Показ резуьтата теста ученика преподавателю
include_once "dtb/dtb.php";
$test = $_GET['td'];

$test_id = explode('_',$test)[1];
echo "<div class='student-wrapper'>";
$testInfoSql = "SELECT * FROM test_results WHERE id = '$test_id' ;";
$InfoResult = mysqli_query($conn, $testInfoSql);
$rowInfo = mysqli_fetch_assoc($InfoResult);
echo "
  <div class='test-info'>
    <p> Индефикатор теста: ".$rowInfo['id']." </p>
    <p> ФИО студента: <b>".$rowInfo['student']."</b>, Класс: <b>".$rowInfo['class']."</b></p>
    <p> Модуль: ".$rowInfo['module']."</p>
    <p> Процент выполнения: ".$rowInfo['percent']."</p>
    <hr>
  </div>
";

$sql = "SELECT * FROM $test";
$result = mysqli_query($conn, $sql);
if ($result) {
  if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)) {
      $num = $row['id'];
      $question = $row['Question_text'];
      $answer = $row['Given_answer'];
      $correct = $row['Correct_answer'];
      $variant = $row['Question_var'];
      if($row['Correctness'] == 0){
        $correctness = '<p> <span style="color: red;"> <b> Ответ неправильный </b>  </span> </p>';
      } else {
        $correctness = '<p> <span style="color: green;"> <b> Ответ правильный </b> </span> </p>';
      }
      if(!($row['Image']=='')){
        $image = "<img src='".$row['Image']."'>";
      } else {
        $image = '';
      }
      echo "
        <div class='question' id='$num'>
        <p> Номер задания: <b style='font-size: larger;'>$num</b>, Вариант: <b style='font-size: larger;'>$variant</b> </p>
        $image
        <p> Текст вопроса: $question </p>
        <p> Ответ ученика: '$answer' </p>
        <p> Правильный ответ: '$correct' </p>
        $correctness
        </div>
      ";
    }
    echo "
    <p> <a href='panel.php'> Вернутся </a> </p>
    </div>
    ";
  } else {
      echo "Не удалось загрузить результаты теста";
    }
  } else {
    echo "Произошла ошибка";
  }

?>
  </body>
</html>
