<?php
//Показ JSON на преподавательской панели
include_once "../../dtb/dtb.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $module = $_POST['module_name'];
  $sql = "SELECT Questions FROM new_module WHERE Name = '$module' ;";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_array($result);
  if(mysqli_num_rows($result)>0){
    echo json_encode($data);
  }
}
?>
