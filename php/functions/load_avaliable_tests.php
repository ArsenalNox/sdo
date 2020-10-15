<?php
session_start();
//Загрузка доступных тестов для ученика
include_once "../../dtb/dtb.php";
$group_id = $_POST['group'];
$student = $_SESSION['UID'];
$sql = "SELECT * FROM current_test WHERE group_to_test = '$group_id'";
$result = mysqli_query($conn, $sql);

$csql = "SELECT * FROM test_results WHERE student = '$student'";
$check = mysqli_query($conn, $csql);
$completed[] = 'null';
if(mysqli_num_rows($check) > 0){
  while ($row = mysqli_fetch_assoc($check)) {
    $completed[] = $row['module'];
  }
}
$check = false;
if(mysqli_num_rows($result) > 0){
  while ($row = mysqli_fetch_assoc($result)) {
      for ($i=0; $i < sizeof($completed); $i++) {
        if($completed[$i] == $row['test_dir']){
          echo " <p class='avaliable-test'>
          ". $row['date']  ."
          ". $row['test_dir'] ."
          ". $row['time_to_complete'] ." Минут
          ". $row['subject'] ."
          Test completed
          </p>
          ";
          $check = true;
          break;
        }
      }
      if(!$check){
        echo " <p class='avaliable-test' onclick='startTest(". $row['id'] .")'>
        ". $row['date']  ."
        ". $row['test_dir'] ."
        ". $row['time_to_complete'] ." Минут
        ". $row['subject'] ."
        </p>
        ";
      }
  }
} else {
  echo "Пока что доступных для вас тестов нет";
}
 ?>
