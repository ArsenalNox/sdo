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
        </form>
        <?php if(isset($error)){echo"<p class='login-error'>$error</p>";} ?>

    </section>
  </body>
</html>
