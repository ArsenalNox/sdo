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
    <meta charset="utf-8">
    <title> Просмотр мероприятий</title>
  </head>
  <body>
    <section class='viewpanel-wrapper'>
      <a href="panel.php" class="to-crmd">
        <button>← Назад</button>
      </a>
      <hr>
      <div class="method-select-wrapper">
        Провести выбор по:
        <select class="method-select" name="method" id='ms1' onchange="loadAssociatedData()">
          <option value="module"> Модулю </option>
          <option value="class"> Классу </option>
          <option value="date"> Дате </option>
          <option value="student"> Студенту </option>
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
      <option value="module-desc">  Модулю убыл.   </option>
      <option value="module-asc">   Модулю возр.   </option>
    </select>
    <br>
    <button type="button" name="button" onclick="showAllResults()">Провести поиск</button>
    </section>
    <div class="test-list-wrapper" id='tlw1'> </div>
    <script src="js/meta.js" charset="utf-8"></script>
    <script type="text/javascript">
      loadAssociatedData()
    </script>
  </body>
</html>
