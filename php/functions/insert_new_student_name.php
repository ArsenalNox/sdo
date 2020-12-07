<?php
//Обновление имени ученика
include_once "../../dtb/dtb.php";
$uiqname = $_COOKIE['UTSID'];
$new_name = $_POST['new_name'];
$ip = $_POST['ip'];
$gr = $_POST['nl'];
$sql = "SELECT NAME FROM group_student WHERE id ='$gr'";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
$gname = $row['NAME'];
$sql = "UPDATE connectons SET student_uid = '$new_name', group_nl='$gname', status='1' WHERE uiqname ='$uiqname'";
$insert = mysqli_query($conn, $sql);
?>
