<?php
include_once "dtb/dtb.php";
if(!($_SERVER['REQUEST_METHOD'] == 'POST')){
  header("Location: index.php");
}
session_start();
$uid = $_SESSION['UID'];
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/student.css">
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <title>Результаты теста</title>
  </head>
  <body>

<?php
  $student = $_SESSION['UID'];
  $module_name = $_SESSION['MODULE'];
  $correct_answers = 0;
  echo "
  <input type='hidden' name='student_uid' value='$uid' id='suid'>
  <input type='hidden' name='student_test_status' value='test_not_selected' id='student_test_status'>
  ";
  echo "
  <section class='student-wrapper'>
  <fieldset class='fieldset'>
  Результаты теста " . $student ;
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
      <p> Ответ ученика: '$question_answer_given'. </p>
      <p> Ответ правильный. </p>
      ";
      $_SESSION["STATE_$i"] = 1;
      $correct_answers++;
    } else {
      echo "
      <p> Ответ ученика: '$question_answer_given'. </p>
      <p> Ответ не правильный! Правильный ответ - '$question_answer_correct' </p>";
      $_SESSION["STATE_$i"] = 0;
    }
    echo "
    </div>
    ";
  }
  if($correct_answers == 0){
    $percent = "0%";
  } else {
    $percent = round($_SESSION['QUESTIONS_QUANTITY']/$correct_answers*10) . "%";
  }
  //Проверка на наличие результата этого теста у ученика в бд
  $sql = "SELECT * FROM test_results WHERE student = '$student' AND module='$module_name';";
  $check = mysqli_query($conn, $sql);
  if($check){
    if(mysqli_num_rows($check) == 0){
      $today = date("Y-m-d");
      $group = $_SESSION['GROUP_UID'];
      //Проверка наличия резуьтатов. (Надо бы по-хорошему эту систему изменить)
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
      if($result){
        //Создание отдельной таблицы для хранения детальных результатов теста
        //Название таблицы - tr_+айди теста ученика
        $sql = "SELECT * FROM test_results WHERE `student` = '$uid' AND `date` ='$today' AND `module` = '$module_name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        echo "$sql, $uid, $today, $module_name, " . $row['id'];
        $result_table_name = 'tr_'.$row['id'];
        //создание таблицы если не существует
        $resulttable_sql = "CREATE TABLE IF NOT EXISTS $result_table_name (
          id int(4) AUTO_INCREMENT,
          Question_var int(4),
          Question_text nvarchar(512),
          Given_answer nvarchar(512),
          Correct_answer nvarchar(512),
          PRIMARY KEY(id)
        )";
        $create_table = mysqli_query($conn, $resulttable_sql);
        for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']; $i++) {
          $variant = $_SESSION["QUESTION_VAR_$i"];
          $question_text = $_SESSION["QUESTION_$i"];
          $question_answer_given = $_POST["ANSW_$i"];
          $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
          $sql = "INSERT INTO $result_table_name (`Question_var`, `Question_text`, `Given_answer`, `Correct_answer`) VALUES (
              '$variant',
              '$question_text',
              '$question_answer_given',
              '$question_answer_correct'
          )";
          $insert = mysqli_query($conn, $sql);
        }
      }

      echo "
      <p> Ваш результат был сохранён! </p>
      <p> Процент правильных ответов: " .$percent. " </p>
      <a class='home' href='index.php?status=true&test=".$result_table_name."'> Вернутся на главную </a> </fieldset> </section>
      ";
    } else {
      echo "Ваш результат уже записан
      <a class='home' href='index.php'> Вернутся на главную </a> </fieldset> </section>";
    }
  }
 ?>
 <script type="text/javascript" src='js/student.js'></script>
 <script type="text/javascript">
   document.getElementById('student_test_status').value = t_cmp;
   set_test_status();
 </script>
  </body>
</html>
