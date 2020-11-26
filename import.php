<?php
include_once "dtb/dtb.php";
require 'php/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
      <form class="import-from" action="import.php" method="post" enctype="multipart/form-data">
        <input type="file" name="uploadedFile" id='fu' class="importfile">
        <input type="submit" name="submit" class="importbutton">
      </form>

    <section class='import-preview' id='ip1'>
        <?php
        if ($_SERVER['REQUEST_METHOD']=='POST') {
          if (isset($_POST['submit'])) {
            echo"<hr> <form method='POST' action='submit_new_module.php' class='fromimport'>
            <input type='text' name='Module_name' placeholder='Название модуля'>
            <input type='text' name='module_subject' placeholder='Название модуля'>
            <input type='number' name='class' placeholder='Класс' max='11' min='0' style='width: 70px' />
            <br>";

            if (isset($_FILES['uploadedFile'])) {
              echo "<div class='importname'> <p>Название файла:   ";
              echo  $_FILES['uploadedFile']['name'];
              $reader = IOFactory::createReader('Xlsx');
              $spreadsheet = $reader->load($_FILES['uploadedFile']['tmp_name']);
              $writer = IOFactory::createWriter($spreadsheet, 'Html');
              // $message = $writer->save('php://output');
              echo "</div>";
            }
            while(true){
              $qquant = 0;
              $qnum_post = 1;
              for ($i=6; $i<10 ; $i++) {
                $variant = 1;
                for ($j=7; $j<17 ; $j+=2) {
                  $qnum = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue();
                  $qtype = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue();
                  $qsubtype = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue();
                  $qcomm = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue();
                  $qtextF = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue();
                  $qtextL = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
                  $qansw = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j+1, $i)->getValue();
                  $qanswb = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(10, $i)->getValue();
                  $qanswc = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(12, $i)->getValue();
                  $qanswd = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(14, $i)->getValue();
                  echo "
                  <div class='importmodule'>
                  <p> Номер вопроса: $qnum, Вариант: $variant</p>
                  <p> Вид задания: $qtype </p>
                  <p> Подвид задания: $qsubtype </p>
                  <p> Комментарий к заданию: $qcomm </p>
                  <p> Текст вопроса: $qtextF $qtextL </p>
                  <p> Правильный ответ: $qansw </p>

                    <input type='hidden' name='question_num_$qnum_post' value='$qnum'>
                    <input type='hidden' name='question_a_num_$qnum_post' value='$qnum'>
                    <input type='hidden' name='question_var_$qnum_post' value='$variant'>
                    <input type='hidden' name='IMAGE' value=''>
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
            <input type='hidden' name='quest_quantity' value='$qquant'>
            <button> Загрузить данный модуль </button>  </form> ";

          }
        }
         ?>
         <div>
      </section>
  </body>
</html>
