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
        <select class="method-select" name="method" id='ms1'>
          <option value="module"> Модулю </option>
          <option value="class"> Классу </option>
          <option value="date"> Дате </option>
          <option value="student"> Студенту </option>
        </select>
      </div>
    <div class="module-list">
    <br> Список модулей <br>
      <?php
      $sql = "SELECT DISTINCT module FROM test_results";
      $result = mysqli_query($conn, $sql);
      if($result){
        if(mysqli_num_rows($result)>0){
            echo "
            <select id='mds1'>
            ";
            while ($row = mysqli_fetch_assoc($result)) {
              $module = $row['module'];
              echo '<option value="'.$module.'"> '.$module.' </option> <br>';
            }
            echo "</select>";
        }
      } else {
        echo "<h3> При загрузке произошла ошибка! </h3>";
      }
      ?>
    </div>
    <button type="button" name="button" onclick="showAllResultsOfModule()">Провести поиск</button>

    </section>
    <div class="test-list-wrapper" id='tlw1'> </div>
    <script src="js/meta.js" charset="utf-8"></script>
  </body>
</html>
