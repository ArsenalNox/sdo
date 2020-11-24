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
              $message = $writer->save('php://output');
            }
          }
        }
        echo "$message";
         ?>
  </body>
</html>
