<?php
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
          setcookie('STS', $id, time()+3600, '/');
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600;700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <title>Вход в панель управления </title>
  </head>
  <body class="panellogin">
    <section class="main">
    <img src="img/Группа.png" class="imgLogin">
      <div class="form">
          <form class="login" action="panel-login.php" method="post">
            <fieldset>
              <legend align="center"><h1 class="text">ВХОД</h1></legend>
              <input type="text" name="uid" placeholder="Логин" class="loginIn">
              <input type="password" name="pwd" placeholder="Пароль" class="password">
              <?php if(isset($error)){echo"<p> $error </p>";} ?>
              <button type="submit" name="" value="Войти" class="button">Войти</button>

            </fieldset>
          </form>
        </div>

    </section>
  </body>
</html>
