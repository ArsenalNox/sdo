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
    <meta charset="utf-8">
    <title>Создание модуля</title>
  </head>
  <body>

    <section class="module-creation-wrapper">
      <a href="panel.php" class="to-crmd"><h4>← Назад</h4></a>
      <hr>
      <h2> Создание модуля </h2>
      <form class='new_module_form' action="submit_new_module.php" method="post" id='nmf'>
        <textarea id='mn' name="module_name" rows="2" cols="40" style="resize:none" placeholder="Название модуля"></textarea>
        <textarea id='ms' name="module_subject" rows='2' cols='40' style="resize:none" placeholder="Премет модуля"></textarea>
      </form>
      <hr>
      <button type="button" name="button" onclick='addQuestion()'> Добавить вопрос </button>
    </section>
  </body>
</html>
