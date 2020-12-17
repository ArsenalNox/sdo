<?php
session_start();
//Создание SQL запроса
include_once "../../dtb/dtb.php";


function loadModuleAnswersTable($id, $link){
	$sql = "SELECT * FROM tr_".$id." ";
	$result = mysqli_query($link, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				if($row['Correctness'] == 1){
					echo "<td style='background-color: #00FF00; width: 20px; height: 20px;' >  </td>";
				} else {
					echo "<td style='background-color: #FF0000; width: 20px; height: 20px;' >  </td>";
				}
			}
		}
	}
}

function loadModuleQuestionQuant($moduleName, $link){
	//echo "Загружаю кол-во вопросов модуля $moduleName";
	$sql = "SELECT Questions FROM new_module WHERE Name='$moduleName'";
	$result = mysqli_query($link, $sql);
	$data = [];
	if($result){
		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_assoc($result);
			$path = "../../".$row['Questions'];
			//print_r($path);
			if(file_get_contents($path)){
				$string = file_get_contents($path);
				$moduleJSON = json_decode($string, true);
				$qquant = 0;
				foreach($moduleJSON as $struct => $quest){
					if(isset($quest['QUESTION_NUM'])){
						$qquant = $quest['QUESTION_NUM'];
					}
				}
				$data['question_quantity'] = $qquant;
			} else {$error = 'Ошибка 3';}
		} else {$error = 'Ошибка 2';}
	} else {$error = 'Ошибка 1';}
	if(isset($error)){$data['errors'] = $error;}
	return $data;
}
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
    $sql = "SELECT * FROM test_results WHERE 1 ";
    break;
}
//ДЕБАГ ИНФОРМАЦИЯ
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
//Добавление дополнительных опций поиска, если таковые имеются
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
        case 'addl-date':
          $date = $_POST["addoption$i"];
          $sql .= "AND date='$date'";
          break;
        case 'addl-module':
          $module = $_POST["addoption$i"];
          $sql .= "AND module='$module'";
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

$_SESSION['sql'] = $sql;
$result = mysqli_query($conn, $sql);

if($result){
  if(mysqli_num_rows($result)>0){
    //Вывод соответсвующей таблицы
    switch ($_POST['method']) {
      case 'module':
	$moduleQ = loadModuleQuestionQuant($module, $conn);
	if(isset($moduleQ['errors'])){
		echo $moduleQ['errors'];
		break;
	}	  //print_r($moduleQuestionQuantity);
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
	";
	for($i=1; $i < $moduleQ['question_quantity']+1; $i++){
		echo "<th>$i</th>";
	}
	echo"<th></th></tr>";
          while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
              <td> ".$row['student']."  </td>
              <td> ".$row['class']."    </td>
              <td> ".$row['date']."     </td>";
	    loadModuleAnswersTable($row['id'], $conn);
	    echo "<td> <a  style='width:100%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
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
            <a style='width:100%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'>
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
          Таблица результатов обучающегося ".$student."
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
    echo "<br>
    <p>
    <a class='tabling' href='php/functions/export.php'> Экспортировать данную таблицу </a>
    </p>";
  } else {
    echo "По данному запросу отсутсвуют результаты";
  }
} else {
  echo "Что-то пошло не так $sql";
}
?>
