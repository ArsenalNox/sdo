<?php
include_once 'dtb/dtb.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $id = $_POST['id'];
  $action = $_POST['action'];
  switch($action){
      case 'confirm':
          $sql = "UPDATE connectons SET status = 1 WHERE id = '$id'; ";
          $result = mysqli_query($conn, $sql);
      break;
      case 'deconfirm':
          $sql = "UPDATE connectons SET status = 0 WHERE id = '$id'; ";
          $result = mysqli_query($conn, $sql);
      break;
  }
} else {
  header("Location: index.php");
}
