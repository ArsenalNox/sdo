<?php
// TODO: Дизайн
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
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="css/fonts.css">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель преподавателя</title>
</head>
<body onload="getConnections()">
<script src="js/panel.js"></script>
<button id="tema" onclick="tema()">Темная тема</button>
<div class="wrapper">

<section class='student-ip-panel'>
  <fieldset class="fieldset">
    <legend align="center"><h1 style="text-transform: uppercase">Устройства</h1></legend>
    <div class="knopka">
    <button type="button" name="button" onclick="getConnections()" class="button2">Обновить соединения</button>
    <button type="button" name="button" onclick="ResetConnections()" class="button2">Обнулить соединения</button>
    </div>
    <hr>
    <div id='scnt'> </div>
  </fieldset>
</section>

<section class="module-wrapper">
  <fieldset class="fieldset">
    <legend align="center"><h2 class="module"> Выбор модуля </h2></legend>
    <div class="module-selector">
      Выбрать класс для тестирования
      <?php
      //Выбираем классы и выводим в список классы
      $groupQuery = "SELECT * FROM group_student;";
      $result = mysqli_query($conn, $groupQuery);
      echo "<select id='group'> <option>--Класс--</option>";
      if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
          $group = $row['NAME'];
          // $clsnum = preg_replace("/[^0-9]/","", $group);
          echo "<option value='$group'> $group </option>";
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
          echo "<select id='subject' onchange='LoadMouleMenu()'> <option>--Предмет--</option>";
          while($row = mysqli_fetch_assoc($result)){
            $sbj = $row['subject'];
            echo "<option class='subject'> $sbj </option>";
          }
          echo "</select>";
        }
        ?>
    </div>
    <br>
    <div class="class-module-confirmation" id='cmd1'>
      Выберите модуль
      <select id="module-select">
        <option> -- Выберите предмет --</option>
      </select>
    </div>
    <br>
    <div class="test-preview" id='tp1'>
    </div>
  </fieldset>

  <!-- <fieldset class="fieldset">
    <legend align="center"><h2 class="module"> Экспортировать таблицу результатов </h2></legend>
    <a href="export.php" class="exel"> <button type="button" name="button" class='export'><pre>Экспортировать таблицу</pre></button> </a>
  </fieldset> -->

    <legend align="center"><h2 class="module"> Мета панель </h2></legend>
    <div class="met">
        <!-- <a href="create_module.php" class='create'>
          <button>Создать модуль</button>
        </a>
        <br> -->
        <a href="viewmod.php" class='viewmod' id="buttonmet">
          <button>Просмотр мероприятий</button>
        </a>
    </div>
</section>
</div>
<script src="js/theme.js"></script>
</body>
</html>
