<?php
//Проверяет авторизацию со стороны учителя
if(isset($_COOKIE['STS'])){
  $teachid = $_COOKIE['STS'];
  $checkteach = "SELECT id FROM teach WHERE uid = '$teachid' ;";
  $check = mysqli_query($conn, $checkteach);
  if(mysqli_num_rows($check) == 0){
    header("Location: panel-login.php");
  }
} else {
  header("Location: panel-login.php");
}
?>
