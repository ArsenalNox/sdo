<?php
//Обновление статуса теста ученика в бд
include_once "../../dtb/dtb.php";
$status = $_POST['status'];
$id = $_POST['id'];
$sql = "UPDATE connectons SET test_status = '$status' WHERE student_uid = '$id'; ";
$result = mysqli_query($conn, $sql);
?>
