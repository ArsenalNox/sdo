<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/student.css">
    <title>Результат теста</title>
  </head>
  <body>
<?php
//Показ резуьтата теста ученика преподавателю
include_once "dtb/dtb.php";
$test = $_GET['td'];
$sql = "SELECT * FROM $test";
$result = mysqli_query($conn, $sql);
if ($result) {
  if(mysqli_num_rows($result) > 0){
    echo "<div class='student-wrapper'>";
    while ($row = mysqli_fetch_assoc($result)) {
      $num = $row['id'];
      $question = $row['Question_text'];
      $answer = $row['Given_answer'];
      $correct = $row['Correct_answer'];
      if(!($row['Image']=='')){
        $image = "<img href='".$row['Image']."'>";
      } else {
        $image = '';
      }
      echo "
        <div class='question' id='$num'>
        <p> Номер вопроса: $num </p>
        $image
        <p> Текст вопроса: $question </p>
        <p> Ответ ученика: '$answer' </p>
        <p> Правильный ответ: '$correct' </p>
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
