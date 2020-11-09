<?php
//Создание SQL запроса
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
  case 'all':
    $sql = "SELECT * FROM test_results";
    break;
}
//Добавление дополнительных опций поиска, если таковые имеются
echo "<pre>";
print_r($_POST);
echo "</pre>";
if(isset($_POST['addoptcount'])){
  if($_POST['addoptcount'] > 0){
    for ($i=1; $i < $_POST['addoptcount']+1; $i++) {
      switch ($_POST["optiontype$i"]) {
        case 'addl-class':
          $class = $_POST["addoption$i"];
          $sql .= "AND class='$class'";
          break;
        case 'addl-student':
          $student = $_POST["addoption$i"];
          $sql .= "AND student='$student'";
          break;
      }
    }
  }
}
//Выбор сортировки
switch ($_POST['sort']) {
  case 'class-asc':
    $sql .= " ORDER BY class ASC ";
    break;
  case 'class-desc':
    $sql .= " ORDER BY class DESC ";
    break;
  case 'date-asc':
    $sql .= " ORDER BY date ASC ";
    break;
  case 'date-desc':
    $sql .= " ORDER BY date DESC ";
    break;
  case 'module-asc':
    $sql .= " ORDER BY module ASC ";
    break;
  case 'module-desc':
    $sql .= " ORDER BY module DESC ";
    break;
  case 'percent-desc':
    $sql .= " ORDER BY percent DESC ";
    break;
  case 'percent-asc':
    $sql .= " ORDER BY percent ASC ";
    break;

}

$result = mysqli_query($conn, $sql);

if($result){
  if(mysqli_num_rows($result)>0){
    //Вывод соответсвующей таблицы
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
              <th> ФИО студента </th>
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
              <td> ".$row['percent']."
              <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
              Смотреть результат </a> </td>
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
            <th> ФИО студента </th>
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
            <td> ".$row['percent']."
            <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
            Смотреть результат </a> </td>
          </tr>
          ";
        }
        echo "</table>";
        break;
      case 'date':
        echo "
        <div class='data-preview'>
          Таблица результатов за ".$date."
        </div>
        <br>
        <table>
          <tr>
            <th> ФИО студента </th>
            <th> Класс </th>
            <th> Модуль </th>
            <th> Дата выполнения </th>
            <th> Процент выполнения </th>
          </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['student']." </td>
            <td> ".$row['class']."</td>
            <td> ".$row['module']." </td>
            <td> ".$row['date']." </td>
            <td> ".$row['percent']."
              <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
              Смотреть результат </a> </td>
          </tr>
          ";
        }
        echo "</table>";
        break;

      case 'student':
        echo "
        <div class='data-preview'>
          Таблица результатов студента ".$student."
        </div>
        <br>
        <table>
          <tr>
            <th> Модуль </th>
            <th> Дата выполнения </th>
            <th> Процент выполнения </th>
          </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['module']." </td>
            <td> ".$row['date']." </td>
            <td> ".$row['percent']." <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
            Смотреть результат </a> </td>
          </tr>
          ";
        }
        echo "</table>";
        break;
      case 'all':
        echo "
        <div class='data-preview'>
          Полная таблица результатов
        </div>
        <br>
        <table>
          <tr>
            <th> ФИО студента </th>
            <th> Класс </th>
            <th> Модуль </th>
            <th> Дата выполнения </th>
            <th> Процент выполнения </th>
          </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['student']." </td>
            <td> ".$row['class']."</td>
            <td> ".$row['module']." </td>
            <td> ".$row['date']." </td>
            <td> ".$row['percent']." <a class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
            Смотреть результат </a> </td>
          </tr>
          ";
        }
        echo "</table>";
      break;
    }
    echo "<br>";
  } else {
    echo "По данному запросу отсутсвуют результаты";
  }
} else {
  echo "Что-то пошло не так";
}

?>
