<?php
//Показ всех вопросов выбранного модуля
include_once "../../dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $module = $_POST['module_name'];
  $sql = "SELECT * FROM new_module WHERE Name = '$module' ;";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($result);
  $path = $data['Questions'];
  $string = file_get_contents("../../$path");
  $json_a = json_decode($string, true);
  foreach ($json_a as $struct => $quest) {
  echo  $quest['QUESTION'] . " <br>
    A) " . $quest['A'] . " ;
    B) " . $quest['B'] . " ;
    C) " . $quest['C'] . " ;
    D) " . $quest['D'] . " <br> <hr> ";
  }
  echo "
    <button type='button' name='button' onclick='StartTest()'>Начать тест</button>
    ";
}
?>
