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
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
</head>
<body onload="getConnections()">
<script src="js/panel.js"></script>

<section class='student-ip-panel'>
  <?php echo "Здравствуйте, ".$_COOKIE['STS']; ?>
  <div id='scnt'> </div>
</section>

<section class="module-wrapper">
  <div class="module-selector">
    <h2>Модуль</h2>
    Выбрать класс для тестирования

    <?php
    //Выбираем классы и выводим в список классы
    $groupQuery = "SELECT * FROM group_student;";
    $result = mysqli_query($conn, $groupQuery);
    echo "<select id='groups'> <option> </option>";
    if(mysqli_num_rows($result) > 0){
      while ($row = mysqli_fetch_assoc($result)) {
        $group = $row['NAME'];
        echo "<option> $group </option>";
      }
    } else {
      //Если пусто
      echo "Занесите в бд классы";
    }
    echo "</select>";
    ?>

  </div>
  <br>
  <div class="subject-selector">
    Выберите предмет
      <?php
      //Список предметов
      $sql = "SELECT DISTINCT subject FROM new_module";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)>0){
        echo "<select id='subject' onchange='LoadMouleMenu()'> <option> </option>";
        while($row = mysqli_fetch_assoc($result)){
          $sbj = $row['subject'];
          echo "<option> $sbj </option>";
        }
        echo "</select>";
      }
       ?>
  </div>
  <br>
  <div class="class-module-confirmation" id='cmd1'>
    Выберите тему
    <select class="" name="">
      <option>Выберите предмет</option>
    </select>
  </div>
  <br>

  <div class="test-preview" id='tp1'>

  </div>

  <button type="button" name="button" onclick='StartTest()'>Начать тест</button>
  <div class="module-creation">
    <h2>Создать Модуль</h2>
    <p>
      <input type="text" name="new_module_name" placeholder="Название Модуля">
      <button type="button" name="button" onclick="CreateModule()">Создать</button>
    </p>
  </div>

</section>

</body>
</html>
