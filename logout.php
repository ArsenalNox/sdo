<?php
include_once "dtb/dtb.php";
session_start();
//"Логирование" выхода
$exitDate = date("Y-m-d H:i:s");
$ssid = $_SESSION['SSID'];
$checkSql = "SELECT id FROM entrylogs WHERE id = '$ssid'" ;
$checkQuery = mysqli_query($conn, $checkSql);
if($checkQuery){
  if(mysqli_num_rows($checkQuery) > 0){
    $sql = "UPDATE entrylogs SET exitTime = '$exitDate' WHERE id='$ssid'";
    $result = mysqli_query($conn, $sql);
    if(!$result){
    }
  }
}

echo "$sql \n $checkSql";
setcookie('STS', '', -1, '/');
session_unset();
session_destroy();

header("Location: panel.php");
?>
