<?php
//Получение модуля по классу
include_once "dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $class = $_POST['gui'];
  $sql = "SELECT * FROM modules WHERE group_id = '$class';";
  $result = mysqli_query($conn, $sql);
  
}
?>
