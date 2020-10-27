<?php
//Получение модуля по классу
include_once "../../dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $sql = "SELECT Name FROM new_module";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result)>0){
    echo "Выберите тему <select id='topic' id='module-select' onchange='ShowQuestions()'> <option>--Выбериие тему--</option>";
    while($row = mysqli_fetch_assoc($result)){
      $theme = $row['Name'];
      echo "<option> $theme </option>";
    }
    echo "</select>";
  }
}
?>
