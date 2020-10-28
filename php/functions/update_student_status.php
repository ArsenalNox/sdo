<?php
//Обновление статуса теста ученика в бд
include_once "../../dtb/dtb.php";
$status = $_POST['status'];
$id = $_POST[''];
switch ($status) {
  case 'not_started':
      $sql = "UPDATE connectons SET test_status = 'not_started' WHERE id = '$id'; ";
  break;

  case 'testing':
      $sql = "UPDATE connectons SET test_status = 'testing' WHERE id = '$id'; ";
  break;

  case 'completed':
      $sql = "UPDATE connectons SET test_status = 'completed' WHERE id = '$id'; ";
  break;

  default:
      $sql = "UPDATE connectons SET test_status = 'not_started' WHERE id = '$id'; ";
    break;
}
$result = mysqli_query($conn, $sql);
?>
