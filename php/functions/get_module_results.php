<?php
//Получение из бд
include_once "../../dtb/dtb.php";
$module = $_POST['module'];

$sql = "SELECT * FROM test_results WHERE module = '$module' ORDER BY `class` DESC";
$result = mysqli_query($conn, $sql);

if($result){
  if(mysqli_num_rows($result)>0){
    echo "
    <div class='data-preview'>
      Кол-во учеников, выполнивших данный модуль ".mysqli_num_rows($result)."
    </div>
    <table>
    <tr>
    <th> Имя студента </th>
    <th> Класс </th>
    <th> Дата выполнения </th>
    <th> Процент выполнения </th>
    </tr>
    ";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "
      <tr>
          <td>
          <a href='viewresult.php?td=tr_".$row['id']."'>
          ".$row['student']."
          </a>
          </td>
      <td>  ".$row['class']." </td>
      <td>  ".$row['date']." </td>
      <td>  ".$row['percent']." </td>

      </tr>
      ";
    }
    echo "</table>";
  } else {
    echo "Отсутсвуют результаты по выбранному модулю";
  }
} else {
  echo "Что-то пошло не так";
}

?>
