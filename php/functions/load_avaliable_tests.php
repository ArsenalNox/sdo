<?php
//Загрузка доступных тестов для ученика
include_once "../../dtb/dtb.php";
$group_id = $_POST['group'];
$sql = "SELECT * FROM current_test WHERE group_to_test = '$group_id'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
  $row = mysqli_fetch_assoc($result);
  echo " <p class='avaliable-test' onclick='startTest(". $row['id'] .")'>
  ". $row['date']  ."
  ". $row['test_dir'] ."
  ". $row['time_to_complete'] ." Минут
  ". $row['subject'] ."
  </p>
  ";
} else {

  echo "ID:$group_id";
  echo "Пока что доступных для вас тестов нет";
}
 ?>
