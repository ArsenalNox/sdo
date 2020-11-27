<?php
  session_start();
  include_once "dtb/dtb.php";
  $error = '';
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    if( ($_POST['uid'] == '') || ($_POST['pwd'] == '') ){
        if($_POST['uid'] == ''){
          $error .= 'Введите логин <br> ';}
        if($_POST['pwd'] == ''){
          $error .= "Введите пароль";}
    } else {
        $pass = $_POST['pwd'];
        $id = $_POST['uid'];
        $sql = "SELECT ID FROM teach WHERE uid = '$id' AND pwd = '$pass'";

        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0){
          setcookie('STS', $id, time()+12000, '/');

          //"Логирование" входящих пользователей в панель управления
          $entryDate = date("Y-m-d H:i:s");
          if(!isset($_COOKIE['UTM'])){
            setcookie('UTM', md5(uniqid()), time()+1200*20*20, '/');
          }
          $_SESSION['SSID'] = uniqid();
          $ssid = $_SESSION['SSID'];
          $name = $_COOKIE['UTM'];
          $ip = $_SERVER['REMOTE_ADDR'];
          $checkSql = "SELECT id FROM entrylogs WHERE id = '$ssid'" ;
          $checkQuery = mysqli_query($conn, $checkSql);
          if($checkQuery){
            if(mysqli_num_rows($checkQuery) == 0){
              $sql = "INSERT INTO `entrylogs`(`id`,`name`,`entryTime`, `ip`) VALUES (
                '$ssid',
                '$name',
                '$entryDate',
                '$ip'
              )";
              $result = mysqli_query($conn, $sql);
              if(!$result){
                echo "$sql \n $checkSql";
              }
            }
          }

          header("Location: panel.php");
          die();
        } else {
          $error = 'Неправильно введены данные';
        }
      }
    }
// TODO: Стоит добавить кэширование пароля
// TODO: Нормально отображение ошибок при неправильно введённых данных
 ?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/main.css">
    <!-- <link rel="stylesheet" href="css/media.css"> -->
    <link rel="stylesheet" href="css/fonts.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600;700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в панель управления </title>
  </head>
  <body class="panellogin">
    <section class="main">
    <img src="img/Группа.png" class="imgLogin">
      <div class="form">
          <form class="login" action="panel-login.php" method="post">
            <fieldset class="fieldsetlogin">
              <legend align="center"><h1 class="text">ВХОД</h1></legend>
              <input type="text" name="uid" placeholder="Логин" class="loginIn">
              <input type="password" name="pwd" placeholder="Пароль" class="password">
              <!-- <?php if(isset($error)){echo"<p> $error </p>";} ?> -->
              <button type="submit" name="" value="Войти" class="button5">Войти</button>
            </fieldset>
          </form>
        </div>
    </section>
  </body>
</html>
