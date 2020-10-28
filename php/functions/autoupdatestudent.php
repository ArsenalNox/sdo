<?php
session_start();
include_once "../../dtb/dtb.php";

$ip = $_SESSION['IP'];
$uid = $_SESSION['UID'];
$group = $_SESSION['GROUP_UID'];

$sql = "SELECT status FROM connectons WHERE student_uid = '$uid' AND ip = '$ip' ";
$result = mysqli_query($conn, $sql);
if($result){
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    if($row['status'] == 1){
      echo "OK";
    }else {
      echo "NO";
    }
    die();
  }
}
die();
