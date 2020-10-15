<?php
//Отправка теста классу
include_once "../../dtb/dtb.php";
$class = $_POST['class'];
$module = $_POST['module'];
$subject = $_POST['subject'];
$time = $_POST['time'];
$today = date("Y-m-d H:i:s");
echo "$class $module $subject $time $today";
$sql = "INSERT INTO current_test (`date`, `test_dir`, `group_to_test`, `time_to_complete`, `subject`, `question_num`) VALUES ('$today', '$module', '$class', '$time', '$subject', '8')";
$result = mysqli_query($conn, $sql);
echo "$result";
