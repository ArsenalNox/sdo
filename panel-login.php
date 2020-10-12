<?php
  include_once "dtb/dtb.php";

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['uid'];
    $pass = $_POST['pwd'];
      $sql = "SELECT ID FROM teach WHERE uid = '$id' AND pwd = '$pass'";
      echo $sql;
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)>0){
        setcookie('STS', $id, time()+3600, '/');
        header("Location: panel.php");
        die();
      } else {
        $error = 'Неправильно введены данные';
      }
    }
 ?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <title>Вход в панель управления </title>
  </head>
  <body>
    <section class="main">
      <form class="login" action="panel-login.php" method="post">
        <input type="text" name="uid" placeholder="Логин">
        <input type="password" name="pwd" placeholder="Пароль">
        <input type="submit" name="" value="Войти">
        <?php if(isset($error)){echo"<p class='login-error'>$error</p>";} ?>
      </form>

    </section>
  </body>
</html>
