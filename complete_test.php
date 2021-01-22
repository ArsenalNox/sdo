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
    <!-- <link rel="stylesheet" href="css/media.css"> -->
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
  <section class='student-wrapper'>
  <fieldset class='fieldset'>";
  for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']+1; $i++) {
    $variant = $_SESSION["QUESTION_VAR_$i"];
    $question_text = $_SESSION["QUESTION_$i"];
    $question_answer_given = $_POST["ANSW_$i"];
    $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
    if(strcasecmp($question_answer_given,$question_answer_correct) == 0){
      $correct_answers++;
    }
  }
  if($correct_answers == 0){
    $percent = "0%";
  } else {
    $percent = round($correct_answers/($_SESSION['QUESTIONS_QUANTITY'])*100) . "%";
  }
  //Проверка на наличие результата этого теста у ученика в бд
  $sql = "SELECT * FROM test_results WHERE student = '$student' AND module='$module_name';";
  $check = mysqli_query($conn, $sql);
  if($check){
    if(mysqli_num_rows($check) == 0){
      $today = date("Y-m-d");
      $group = $_SESSION['GROUP_UID'];
      if(isset($_SESSION['TEST_ID'])){
        $module_id = $_SESSION['TEST_ID'];
      }else{
      	$module_id = '0';
      }
      $sql = "INSERT INTO `test_results` (`test_id`, `student`, `class`, `date`, `module`, `percent`, `sent`) VALUES (
	'$module_id',
	'$student',
        '$group',
        '$today',
        '$module_name',
	'$percent',
	'0'
      )";
     // echo "$sql";
      $result = mysqli_query($conn, $sql);
      if($result){
        //Создание отдельной таблицы для хранения детальных результатов теста
        //Название таблицы - tr_+айди теста ученика
        $sql = "SELECT * FROM test_results WHERE `student` = '$uid' AND `date` ='$today' AND `module` = '$module_name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $result_table_name = 'tr_'.$row['id'];
        //создание таблицы если не существует
        $resulttable_sql = "CREATE TABLE IF NOT EXISTS $result_table_name (
          id int(4) AUTO_INCREMENT,
          Question_var int(4),
          Question_text varchar(512),
          Given_answer varchar(512),
          Correct_answer varchar(512),
          Correctness tinyint(1),
      	  Image varchar(512),
      	  qtype varchar(512),
          PRIMARY KEY(id)
        )";
        $create_table = mysqli_query($conn, $resulttable_sql);
        for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']+1; $i++) {
          echo "вопрос $i";
          $variant = $_SESSION["QUESTION_VAR_$i"];
          $question_text = $_SESSION["QUESTION_$i"];
          $question_answer_given = $_POST["ANSW_$i"];
          $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
          if(isset($_SESSION["QUESTION_IMAGE_$i"])){
            $image = $_SESSION["QUESTION_IMAGE_$i"];
          } else { $image = ''; }
          if(isset($_SESSION["QUESTION_IMAGE_$i"])){

          }
	  if(isset($_SESSION["Question_type_$i"])){
	  	$qtype = $_SESSION["Question_type_$i"];
	  }else{
	  	$qtype = 'empty';
	  }
   //       echo "$image";
          if(strcasecmp($question_answer_given,$question_answer_correct) == 0){$correct = 1;} else {
            $correct = 0;
          }
          $sql = "INSERT INTO $result_table_name (`Question_var`, `Question_text`, `Given_answer`, `Correct_answer`, `Correctness`, `qtype`, `Image`) VALUES (
              '$variant',
              '$question_text',
              '$question_answer_given',
              '$question_answer_correct',
      	      '$correct',
      	      '$qtype',
              '$image'
          )";
	    //echo "<br> $sql <br>";
          $insert = mysqli_query($conn, $sql);
        }
      }
      // echo "
      // <p> Ваш результат был сохранён! </p>
      // <p> Процент правильных ответов: " .$percent. " </p>
      // <a class='home' href='index.php?status=true&test=".$result_table_name."'> Вернутся на главную </a> </fieldset> </section>
      // ";
      // echo "
      // <script type='text/javascript' src='js/student.js'></script>
      // <script type='text/javascript'>
      // var status = true
      // var test = '".$result_table_name."'
      // sendtestinfo()
      // </script>
      // ";
    } else {
      echo "Ваш результат уже записан
      <a class='home' href='index.php'> Вернутся на главную </a> </fieldset> </section>";
    }
  }
  // echo "<section class='debug'> <pre> " . print_r($_SESSION) . "</pre> </section> <br> <hr>";
  // echo "<section class='debug'> <pre> " . print_r($_POST) . "</pre> </section>";
 ?>
 <script type="text/javascript">
   document.getElementById('student_test_status').value = t_cmp;
   set_test_status();
   window.location.href = "index.php";
 </script>
  </body>
</html>
