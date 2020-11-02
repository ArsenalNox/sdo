<?php
//Получаем из таблицы результатов соответсвующие данные для создание выпадающего списка для выбора
include_once "../../dtb/dtb.php";
include_once "code_functions.php";

$data = $_POST['data'];
if($data == 'date') {
  echo "<input id='dvm1' type='date'>";
} elseif ($data == 'all') {
  echo "<br> <select id='dvm1' style='display:none'> <option value='all'> all </option> </select>
  ";
} else {
  $sql = "SELECT DISTINCT $data FROM test_results";
  $result = mysqli_query($conn, $sql);
  if($result){
    if(mysqli_num_rows($result)>0){
        echo "
        <br>
        <select id='dvm1'>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          $module = $row["$data"];
          echo '<option value="'.$module.'"> '.$module.' </option> <br>';
        }
        echo "</select> <br>";
        echo createDataset('student', $conn);
    }
  } else {
    echo "<h3> При загрузке произошла ошибка! </h3>";
  }
}
?>
