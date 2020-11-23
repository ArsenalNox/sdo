<?php
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
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <section class="main">
      <form class="import-from" action="import.php" method="post" enctype="application/x-www-form-urlencoded">
        <input type="file" name="uploadedFile" id='fu'>
        <input type="submit" name="submit">
      </form>
    </section>

    <section class='import-preview' id='ip1'>
        <?php
        if ($_SERVER['REQUEST_METHOD']=='POST') {
          if (isset($_POST['submit'])) {
            if (isset($_POST['uploadedFile'])) {
              echo "Вы импортировали модуль";
            } else {
              echo "Выберите файл";
            }
          }
        }
         ?>
    </section>
  </body>
</html>
