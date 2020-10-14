<?php
//Отправка теста классу
include_once "../../dtb/dtb.php";
$class = $_POST['class'];
$module = $_POST['module'];
$subject = $_POST['subject'];
echo "$class $module $subject";
