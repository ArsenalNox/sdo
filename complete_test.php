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
  echo " <section class='student-wrapper'> Your test results, " . $_SESSION['UID'];
  for ($i=1; $i < $_SESSION['QUESTIONS_QUANTITY']; $i++) {
    $variant = $_SESSION["QUESTION_VAR_$i"];
    $question_text = $_SESSION["QUESTION_$i"];
    $question_answer_given = $_POST["ANSW_$i"];
    $question_answer_correct = $_SESSION["CORRECT_ANSW_$i"];
    echo "
    <div class='question-result'>
      <p> Question number $i, variant $variant </p>
      <p> Question: $question_text</p>
      ";
    if(strcasecmp($question_answer_given,$question_answer_correct) == 0){
      echo "<p>You answered '$question_answer_given' Your answer is correct!</p>";
    } else {
      echo "<p>You answered '$question_answer_given' Your answer is not correct! Correct answer is $question_answer_correct </p>";
    }
    echo "</div>";
  }

  //Exporting to excel

  echo "<br> <a href='index.php'> Go to index </a> </section>";
 ?>

  </body>
</html>
