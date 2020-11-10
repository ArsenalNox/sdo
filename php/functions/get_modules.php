<?php
//Получение модуля по классу
include_once "../../dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $subj = $_POST['subject'];
  $sql = "SELECT Name FROM new_module WHERE subject='$subj'";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result)>0){
    echo "Выберите модуль <select id='module-select' onchange='ShowQuestions()'> <option>--Выбериие модуль--</option>";
    while($row = mysqli_fetch_assoc($result)){
      $theme = $row['Name'];
      echo "<option> $theme </option>";
    }
    echo "</select>";
  }
}
?>
