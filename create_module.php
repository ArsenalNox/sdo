<?php
  session_start();
  $_SESSION['QUESTIONS_QUANTITY_CREATED'] = 1;
  include_once "dtb/dtb.php";
  if(isset($_COOKIE['STS'])){
    $teachid = $_COOKIE['STS'];
    $checkteach = "SELECT id FROM teach WHERE uid = '$teachid' ;";
    $check = mysqli_query($conn, $checkteach);
    if(mysqli_num_rows($check) == 0){
      header("Location: panel-login.php");
      die();
    }
  } else {
    header("Location: panel-login.php");
    die();
  }
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/module.css">
    <meta charset="utf-8">
    <title>Создание модуля</title>
  </head>
  <body>

    <section class="module-creation-wrapper">
    <div class="section">
        <a href="panel.php" class="to-crmd">
          <button class="button">← Назад</button>
        </a>
        <hr>
        <h2> Создание модуля </h2>
        <form class='new_module_form' action="submit_new_module.php" method="post" id='nmf'>
          <textarea id='mn' name="module_name" rows="2" cols="40" style="resize:none" placeholder="Название модуля"></textarea>
          <textarea id='ms' name="module_subject" rows='2' cols='40' style="resize:none" placeholder="Премет модуля"></textarea>
        </form>
        <hr>
        <button class="button" type="button" name="button" onclick='addQuestion()'> Добавить вопрос </button>
      </div>
    </section>
  <script type="text/javascript">
    var current_question_number = 1;

    function addQuestion(){
      current_question_number++
      //Создание оболочки для текста вопроса
      var new_question = document.createElement('div');
      new_question.className = 'question';
      new_question.id = "q_"+current_question_number;
      var question_textarea = document.createElement('textarea');
      question_textarea.name = 'question_text_'+current_question_number;
      question_textarea.rows = '8';
      question_textarea.cols = '80';
      question_textarea.style.resize = "none";
      new_question.append(question_textarea);
      document.getElementById('nmf').append(new_question);
    }

  </script>
  </body>
</html>
