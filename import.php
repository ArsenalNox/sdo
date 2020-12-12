<?php
include_once "dtb/dtb.php";
include_once "php/functions/checkAuth.php";

require 'php/functions/code_functions.php';
require 'php/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// TODO: Кол-во вопросов определяется автоматически.
// TODO: Кол-во вариантов задания определяется автоматически и записывается без повторений.
// TODO: Записывать комметарий к заданию, вид задания и подвид задания.
// TODO: Возможность добавить задания с 4 или 5 вариантами

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
    <title>Импорт модуля</title>
  </head>
  <body>

    <section>
    <div class="import">
      <form class="import-from" action="import.php" method="POST" enctype='multipart/form-data'>
        <input type="file" name="uploadedFile" id='fu' class="importfile">
        <input type="submit" name="submit" class="importbutton">
      </form>

    <section class='import-preview' id='ip1'>
        <?php
        if ($_SERVER['REQUEST_METHOD']=='POST') {
          if (isset($_POST['submit'])) {
            echo"<hr> <form method='POST' action='submit_new_module.php' class='fromimport' enctype='multipart/form-data'>
            <input type='text' name='Module_name' placeholder='Название модуля'>
            <input type='text' name='module_subject' placeholder='Название предмет'>
            <input type='number' name='class' placeholder='Класс' max='11' min='0' style='width: 70px' />
            <br>";

            if (isset($_FILES['uploadedFile'])) {
              echo "<div class='importname'> <p>Название файла:   ";
              echo  $_FILES['uploadedFile']['name'];
              $reader = IOFactory::createReader('Xlsx');
              $spreadsheet = $reader->load($_FILES['uploadedFile']['tmp_name']);
              $writer = IOFactory::createWriter($spreadsheet, 'Html');
              echo "</div>";
            }
            while(true){
              $qquant = 0;
              $qnum_post = 1;
              for ($i=6; $i<20 ; $i++) {
                $variant = 1;
                if( strlen($spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $i)->getValue())<1 ){
                  echo "<p>
                  Пустой вопрос.
                  </p>";
                  break;
                }
                for ($j=7; $j<17 ; $j+=2) {
                  $qnum = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue();
                  $qtype = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue();
                  $qsubtype = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue();
                  $qcomm = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue();
                  $qtextF = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue();
                  $qtextL = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
                  if ( strlen($spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue())<1 ) {
                    $variant++;
                    continue;
                  }
                  $qansw = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j+1, $i)->getValue();
                  //Проверка на кол-во вариантов ответа, если один из них отсутвует - впорос пропускается
                  $qanswb = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(10, $i)->getValue();
                  if(strlen($qanswb)<1){ continue;}
                  $qanswc = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(12, $i)->getValue();
                  if(strlen($qanswc)<1){ continue;}
                  $qanswd = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(14, $i)->getValue();
                  if(strlen($qanswd)<1){ continue;}

                  echo "
                  <div class='importmodule'>
                  <p> Номер вопроса: $qnum, Вариант: $variant</p>
                  <p> Вид задания: $qtype </p>
                  <p> Подвид задания: $qsubtype </p>
                  <p> Комментарий к заданию: $qcomm </p>
                  <p> Текст вопроса: $qtextF $qtextL </p>
                  <p> Правильный ответ: $qansw </p>
                    <input type='file' name='question_image_$qnum_post' />
                    <input type='hidden' name='question_num_$qnum_post' value='$qnum'>
                    <input type='hidden' name='question_a_num_$qnum_post' value='$qnum'>
                    <input type='hidden' name='question_var_$qnum_post' value='$variant'>
	                  <input type='hidden' name='question_type_$qnum_post'value='$qtype'>
		                <input type='hidden' name='question_subtype_$qnum_post' value='$qsubtype'>
		                <input type='hidden' name='question_text_$qnum_post' value='$qtextF $qtextL'>
                    <input type='hidden' name='question_answer_a_$qnum_post' value='$qansw'>
                    <input type='hidden' name='question_answer_b_$qnum_post' value='$qanswb'>
                    <input type='hidden' name='question_answer_c_$qnum_post' value='$qanswc'>
                    <input type='hidden' name='question_answer_d_$qnum_post' value='$qanswd'>
                  </div>
                  <hr>";
                  $variant++;
                  $qquant++;
                  $qnum_post++;
                }
              }
              break;
            }
            echo"
            Найдено $qnum вопросов, всего с вариантами $qquant
            <input type='hidden' name='quest_quantity' value='$qquant'>
            <button> Загрузить данный модуль </button>  </form> ";
          }
        }
         ?>
         <div>
      </section>
  </body>
</html>
