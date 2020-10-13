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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
</head>
<body>
<script src="js/panel.js"></script>
  <section class='student-ip-panel'>
    <?php
        echo $_COOKIE['STS'];
        $sql = "SELECT * FROM connectons;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){
                $ip = $row['ip'];
                $status = $row['status'];
                $uid = '';
                $uid = $row['student_uid'];
                $id = $row['id'];
                switch($status){
                    case 0:
                        echo "
                        <p> <button onclick='ConfirmStudent($id)'> Подтвердить </button> $ip : $uid <p>
                        ";
                        break;
                    case 1:
                        echo "
                        <p> <button class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтвердить </button> $ip : $uid </p>
                        ";
                        break;
                }
            }
        } else {
            echo "Пока никого нету";
        }
    ?>
  </section>

<section class="module-wrapper">
  <div class="module-selector">
    <h2>Модуль</h2>
    <p>
    Выбрать класс для тестирования
    <?php
    //Выбираем классы и выводим в список классы
    $groupQuery = "SELECT * FROM group_student;";
    $result = mysqli_query($conn, $groupQuery);
    echo "<select id='groups'>";
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

  <div class="subject-selector">
    </p>
    Выберите предмет
      <?php
      //Список предметов
      $sql = "SELECT DISTINCT subject FROM new_module";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)>0){
        echo "<select id='subject'>";
        while($row = mysqli_fetch_assoc($result)){
          $sbj = $row['subject'];
          echo "<option> $sbj </option>";
        }
        echo "</select>";
      }
      // создать 2 выпадающих списка для выбора предмета и темы (модуля)
       ?>
    <br>
    </div>

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
