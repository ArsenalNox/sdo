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
    <link rel="stylesheet" href="css/main.css">
    <!-- <link rel="stylesheet" href="css/media.css"> -->
    <link rel="stylesheet" href="css/fonts.css">
    <meta charset="utf-8">
    <title> Просмотр мероприятий </title>
    <style>
      body{
        font-size: 25px;
      }
    </style>
  </head>
  <body>
    <section class='viewpanel-wrapper'>
      <a href="panel.php" class="to-crmd">
        <button class="to-crmd">Назад</button>
      </a>
      <hr>
      <div class="method-select-wrapper">
        Провести выбор по:
        <select class="method-select" name="method" id='ms1' onchange="loadAssociatedData()">
          <option value="module"> Модулю </option>
          <option value="class"> Классу </option>
          <option value="date"> Дате </option>
          <option value="student"> Обучающемуся </option>
          <option value="all"> Показать всё </option>
        </select>
      </div>
    <div class="data-select-wrapper" id='dsw1'>
    </div>
    Сортировать по:
    <select class="sort-by" name="sort" id='ss1'>
      <option value="class-desc"> Классу убыв. </option>
      <option value="class-asc">  Классу возр. </option>
      <option value="date-desc">  Дате убыв.   </option>
      <option value="date-asc">   Дате возр.   </option>
      <option value="module-desc">  Модулю убыв.   </option>
      <option value="module-asc">   Модулю возр.   </option>
      <option value="percent-desc">  Процент выполнения убыв.   </option>
      <option value="percent-asc">   Процент выполнения возр.   </option>
    </select>
    <br>
    <div class="addv-opt-wrapper" id='apt1'>
      <p id='pel' class="addv-p" onclick='showElem("apt2")'> Дополнительные опции +</p>
      <br>
      <div id='s-holder' class='add-opt-select'>
      </div>
    </div>
    <br>
    <button class="search" type="button" name="button" onclick="showAllResults()">Провести поиск</button>
    </section>
    <div class="test-list-wrapper" id='tlw1'> </div>
    <script src="js/meta.js" charset="utf-8"></script>
    <script type="text/javascript">
      loadAssociatedData();
      var display = false;
      function showElem(id){
        switch (display) {
          case false:
            document.getElementById('pel').innerText = 'Дополнительные опции -';
            document.getElementById('s-holder').style.display = 'grid';
            display = true;
            break;

          case true:
            document.getElementById('pel').innerText = 'Дополнительные опции +';
            document.getElementById('s-holder').style.display = 'none';
            display = false;
            break;
        }
      }

    </script>
  </body>
</html>
