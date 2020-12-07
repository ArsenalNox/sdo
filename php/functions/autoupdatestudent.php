<?php
session_start();
include_once "../../dtb/dtb.php";

$ip = $_SESSION['IP'];
$uiqname = $_COOKIE['UTSID'];
$sql = "SELECT status FROM connectons WHERE uiqname = '$uiqname' ";
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
  } else {echo "NO";}
} else {echo "error";}
die();
