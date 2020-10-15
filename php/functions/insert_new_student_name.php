<?php
//Обновление имени ученика
include_once "../../dtb/dtb.php";
$new_name = $_POST['new_name'];
$ip = $_POST['ip'];
$sql = "UPDATE connectons SET student_uid = '$new_name' WHERE ip ='$ip'";
$insert = mysqli_query($conn, $sql);

?>
