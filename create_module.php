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
    <!-- <link rel="stylesheet" href="css/media.css"> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Создание модуля</title>
    <style media="screen">

      fieldset{
        border: none;
        margin: 0;
        padding: 0;
      }

      .answers{
        display: grid;
      }

      .txa-wrapper{
          display: flex;
      }

      .correct_answer{
        border: 2px red dotted;
      }
    </style>
  </head>
  <body>

    <section class="module-creation-wrapper">
    <section class="section" style="color: #606060;">
        <a href="panel.php" class="to-crmd">
          <button class="to-crmd">Назад</button>
        </a>
        <hr>
        <h2> Создание модуля </h2>
        <form class='new_module_form' action="submit_new_module.php" method="POST" id='nmf' enctype="multipart/form-data">
          Модуль для класса
          <select style="height: 34px; position: relative; margin-bottom: 5px" name="class" class="class">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
          </select>
          <fieldset>
          <textarea id='mn' name="Module_name" rows="2" cols="40" style="resize:none" placeholder="Название модуля"></textarea>
          <textarea id='ms' name="module_subject" rows='2' cols='40' style="resize:none" placeholder="Премет модуля"></textarea>
          </fieldset>
          <hr>
          <button class="getbutton" type="button" name="button" onclick='addQuestion()'> Добавить вопрос </button>
          <input type="hidden" value="0" name='quest_quantity' id='qqn'>
          <input class="send" type="submit" text="Создать модуль">
        </form>
      </section>
    </section>

  <script type="text/javascript">

    var current_question_number = 1;
    function addQuestion(){
      //Создание оболочки для текста
      var new_question = document.createElement('fieldset');
        new_question.className = 'question';
        new_question.id = "q_" + current_question_number;

      //Оболочка для номера вопроса и кнопки добавления варианта
      var question_info_field = document.createElement('fieldset');
        question_info_field.className = 'quest_num_f';

      //Вопрос №
      var par = document.createElement('h2');
        par.innerText = 'Вопрос ' + current_question_number;
        par.style.margin = '1rem';

      //Кнопка для создания варианта
      var new_var_button = document.createElement('button');
        new_var_button.id = current_question_number
        new_var_button.innerText = 'Добавить вариант';
        new_var_button.onclick = AddNewVar(current_question_number);
        new_var_button.type = 'button';

      //Оболочка для оболочки текстовых полей....
      var txarea_wrp = document.createElement('fieldset');
        txarea_wrp.className = 'txa-wrapper';

      //Поле для текста вопроса
      var question_textarea = document.createElement('textarea');
        question_textarea.placeholder = 'Текст вопроса';
        question_textarea.name = 'question_text_'+current_question_number;
        question_textarea.rows = '13';
        question_textarea.cols = '80';
        question_textarea.required = true;
      //Оболочка для ответов
      var answer_field = document.createElement('fieldset');
        answer_field.className = 'answers';

      //Ответы
      var question_answer_a = document.createElement('textarea');
        question_answer_a.className = 'correct_answer'
        question_answer_a.name = 'question_answer_a_'+current_question_number;
        question_answer_a.rows = '3';
        question_answer_a.cols = '15';
        question_answer_a.style.resize = "none";
        question_answer_a.required = true;
      var question_answer_b = document.createElement('textarea');
        question_answer_b.name = 'question_answer_b_'+current_question_number;
        question_answer_b.rows = '3';
        question_answer_b.cols = '15';
        question_answer_b.style.resize = "none";
      var question_answer_c = document.createElement('textarea');
        question_answer_c.name = 'question_answer_c_'+current_question_number;
        question_answer_c.rows = '3';
        question_answer_c.cols = '15';
        question_answer_c.style.resize = "none";
      var question_answer_d = document.createElement('textarea');
        question_answer_d.name = 'question_answer_d_'+current_question_number;
        question_answer_d.rows = '3';
        question_answer_d.cols = '15';
        question_answer_d.style.resize = "none";
      var image_input = document.createElement('input');
        image_input.type = 'file';
        image_input.name = 'question_image_'+current_question_number;

      //Добавляем это всё в основной див
      question_info_field.append(par)
      answer_field.append(question_answer_a, question_answer_b, question_answer_c, question_answer_d, image_input);
      txarea_wrp.append(question_textarea, answer_field)
      new_question.append(question_info_field, txarea_wrp);
      document.getElementById('nmf').append(new_question);
      document.getElementById('qqn').value = current_question_number;
      current_question_number++
    }

    function AddNewVar(){
      console.log('Добавляю вариант');
    }

  </script>
  </body>
</html>
