<?php
//Назначает неподтверждённый статус студенту по suid
session_start();
include_once "../../dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['suid'])){}
    $suid = $_POST['suid'];
    $sql = "UPDATE connectons SET status='0', student_uid='', group_nl='' WHERE student_uid='$suid';";
    $result = mysqli_query($conn, $sql);
    if($result){
      echo "done";
      session_unset();
      session_destroy();
    } else {
      echo "$suid $sql";
    }
}else {
  header('Location: ../../index.php');
  die();
}
die();
?>
