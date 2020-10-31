<?php
//Получение из бд
include_once "../../dtb/dtb.php";
switch ($_POST['method']) {
  case 'module':
    $module = $_POST['data'];
    $sql = "SELECT * FROM test_results WHERE module = '$module'";
    break;
  case 'class':
    $class = $_POST['data'];
    $sql = "SELECT * FROM test_results WHERE class = '$class'";
    break;
  case 'date':
    $date = $_POST['data'];
    $sql = "SELECT * FROM test_results WHERE date = '$date'";
    break;
  case 'student':
    $student = $_POST['data'];
    $sql = "SELECT * FROM test_results WHERE student = '$student'";
    break;

  default:
    // code...
    break;
}

// $module = $_POST['data'];
// $sql = "SELECT * FROM test_results WHERE module = '$module' ORDER BY `class` DESC";
$result = mysqli_query($conn, $sql);

if($result){
  if(mysqli_num_rows($result)>0){
    switch ($_POST['method']) {
      case 'module':
          echo "
          <div class='data-preview'>
            <p>Таблица результатов модуля ".$module."</p>
            <p>Кол-во учеников, выполнивших данный модуль ".mysqli_num_rows($result)."</p>
          </div>
          <br>
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
            <td> ".$row['student']."  </td>
            <td>  ".$row['class']."   </td>
            <td>  ".$row['date']."    </td>
            <td> ".$row['percent']." <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."'> Смотреть результат </a> </td>
            </tr>
            ";
          }
          echo "</table>";

        break;
      case 'class':
        echo "
        <div class='data-preview'>
          Таблица результатов класса ".$class."
        </div>
        <br>
        <table>
        <tr>
        <th> Имя студента </th>
        <th> Модуль </th>
        <th> Дата выполнения </th>
        <th> Процент выполнения </th>
        </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
          <td> ".$row['student']." </td>
          <td> ".$row['module']." </td>
          <td> ".$row['date']." </td>
          <td> ".$row['percent']." <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."'> Смотреть результат </a> </td>
          </tr>
          ";
        }
        echo "</table>";
        break;
      case 'date':

        break;

      case 'student':

        break;
    }


  } else {
    echo "По данному запросу отсутсвуют результаты";
  }
} else {
  echo "Что-то пошло не так";
}

?>
