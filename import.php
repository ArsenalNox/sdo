<?php
// TODO: Загрузка эксель файла
// TODO: Превью загруженной таблицы, конпка подверждения экспорта
// TODO: Экспорт в submit module


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
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <section class="main">
      <form class="import-from" action="import.php" method="post" enctype="multipart/form-data">
        <input type="file" name="uploadedFile" id='fu'>
        <input type="submit" name="submit">
      </form>

    <section class='import-preview' id='ip1'>
        <?php
        if ($_SERVER['REQUEST_METHOD']=='POST') {
          if (isset($_POST['submit'])) {

            echo "<pre>".print_r($_FILES)."</pre>";

            if (isset($_FILES['uploadedFile'])) {
              echo $_FILES['uploadedFile']['name'];
              $reader = IOFactory::createReader('Xlsx');
              $spreadsheet = $reader->load($_FILES['uploadedFile']['tmp_name']);
              $writer = IOFactory::createWriter($spreadsheet, 'Html');
              // $message = $writer->save('php://output');
            }
            echo"<hr> <form>
            <input type='text' name='Module_name' placeholder='Название модуля'>
            <input type='text' name='module_subject' placeholder='Название модуля'>
            ";
            while(true){
              $qquant = 0;
              for ($i=6; $i<8 ; $i++) {
                $variant = 1;
                for ($j=8; $j<13 ; $j++) {
                  $qnum = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $i)->getValue();
                  $qtype = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue();
                  $qsubtype = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue();
                  $qcomm = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue();
                  $qtextF = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $i)->getValue();
                  $qtextL = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i)->getValue();
                  $qansw = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j+1, $i)->getValue();
                  echo "
                  <div>
                  <p> Номер вопроса: $qnum, Вариант: $variant</p>
                  <p> Вид задания: $qtype </p>
                  <p> Подвид задания: $qsubtype </p>
                  <p> Комментарий к заданию: $qcomm </p>
                  <p> Текст вопроса: $qtextF $qtextL </p>
                  <p> Правильный ответ: $qansw </p>
                  <hr>
                  <fieldset>
                    <input type='hidden' name='QUESTION_NUM'>
                    <input type='hidden' name=''>
                    <input type='hidden' name=''>
                    <input type='hidden' name=''>
                    <input type='hidden' name=''>
                    <input type='hidden' name=''>
                  </fieldset>
                  </div>
                  ";
                  $variant++;
                  $qquant++;
                }
              }
              break;
            }
            echo"

            <button> Загрузить данный тест </button>  </form> $qquant ";

          }
        }
         ?>
      </section>
  </body>
</html>
