<?php

session_start();
include_once "../../dtb/dtb.php";

function loadModuleAnswersTable($id, $link, int $maxQ = 0){
	//Загружает ответы ученика за модуль
	$loaded = 0;
	$sql = "SELECT * FROM tr_".$id." ";
	$result = mysqli_query($link, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				$loaded++;
				echo "<td style='background-color: ";
				if($row['Correctness'] == 1){
					echo "#00FF00;";
					$crts = '1';
				} else {
					echo "#FF0000;";
					$crts = '0';
				}
				echo " width: 20px; height: 20px; position:relative;' onclick=showQuetionPopUp(".$id.",".$row['id'].")> <span style='display:none'> $crts </span> </td>";
			}
		}
		if( $maxQ !== 0 ){
			while($loaded < $maxQ){
				echo "<td style='background-color: #FFFFFF;'>  </td>";
				$loaded++;
			}
		}
	}
}

function loadModuleQuestionQuant($moduleName, $link){
	//Получает кол-во вопросов модуля
	// NOTE: Это можно было бы уместить в 1 SQL запрос...
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
			} else {$error = 'Ошибка 3: Не удалось получить инофрмацию о модуле.';}
		} else {$error = 'Ошибка 2: Отсутсвует результат запроса.';}
	} else {$error = 'Ошибка 1: Не удалось получить ответ на запрос.';}
	if(isset($error)){$data['errors'] = $error;}
	return $data;
}

function loadMaxQuestionQuant($target, $link, string $targetLiteral = ''){
	//Получает максимальное кол-во колонок ответов из текущего запроса
	$sql = "SELECT DISTINCT module FROM test_results ";
	if($targetLiteral !== ''){
		switch($targetLiteral){
			case "student":
					$sql .= "WHERE student = '$target' ";
				break;
			case "class":
					$sql .= "WHERE class = '$target' ";
				break;
			case "date":
					$sql .= "WHERE date = '$target' ";
				break;
		}
	}
	$maxQnum['qnum'] = 0;
	$result = mysqli_query($link, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				$newNum = loadModuleQuestionQuant($row['module'], $link);
				if( $newNum['question_quantity'] > $maxQnum['qnum'] ){
					$maxQnum['qnum'] = $newNum['question_quantity'];
				}
			}
		}else{ $maxQnum['errors'] = 'Ошибка 2';}
	}else{ $maxQnum['errors'] = 'Ошибка 1';}
	return $maxQnum;
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
// TODO: Добавить кнопку смореть похожее
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
	}
	//print_r($moduleQuestionQuantity);
	echo "
          <div class='data-preview'>
            <p>Таблица результатов модуля ".$module."</p>
            <p>Кол-во учеников, выполнивших данный модуль ".mysqli_num_rows($result)."</p>
	    <hr>
          </div>
          <br>
          <table id='table-1'>
            <tr>
              <th onclick='sortTable(0)'> ФИО студента </th>
              <th onclick='sortTable(1)'> Класс </th>
              <th onclick='sortTable(2)'> Дата выполнения </th>
	";
	for($i=1; $i < $moduleQ['question_quantity']+1; $i++){
		echo "<th onclick='sortTable(".($i+2).")' style='width:30px; height:20px; position: relative;'>$i</th>";
	}
	echo"<th>Действия</th></tr>";
          while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
              <td> ".$row['student']."  </td>
              <td> ".$row['class']."    </td>
              <td> ".$row['date']."     </td>";
	      loadModuleAnswersTable($row['id'], $conn, $moduleQ['question_quantity']);
	      echo "
		<td style='display:flex'>
			<a style='width:50%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'> Смотреть результат </a>
			<a style='width:50%' href='#' onclick='showSimilar(".$row['id'].")'> Смотреть похожее </a>
		</td>
            </tr>
            ";
          }
          echo "</table>";
        break;

      case 'class':
	// TODO: Показ таблицы как с модулями
	// TODO: Определить максимальное кол-во ответов из решённых этим классом модулей и построить соответсвущию таблицу
	// TODO: Добавить каждой ячейке таблицы с ответом tooltip, нажав на который покажется текст вопроса, правильный ответ и ответ ученика
	$moduleQ = loadMaxQuestionQuant($class, $conn, 'class');
	if(isset($moduleQ['errors'])){
		echo $moduleQ['errors'];
		die();
	}
        echo "
        <div class='data-preview'>
          Таблица результатов класса ".$class."
        </div>
        <br>
        <table id='table-1'>
          <tr>
            <th onclick='sortTable(0)'> ФИО студента </th>
            <th onclick='sortTable(1)'> Модуль </th>
            <th onclick='sortTable(2)'> Дата выполнения </th>";
	for($i=1; $i<$moduleQ['qnum']+1; $i++){
		echo"<th onclick='sortTable(".($i+2).")' >$i</th>";
	}
	echo "<th> Действия </th>
          </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['student']." </td>
            <td> ".$row['module']." </td>
	    <td> ".$row['date']." </td>";
	    loadModuleAnswersTable($row['id'],$conn, $moduleQ['qnum']);
          echo"
	    <td style='display:flex'>
				<a style='width: 50%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'> Смотреть результат </a>
				<a style='width: 50%' href='#' onclick='showSimilar(".$row['id'].")'> Смотреть похожее </a> </td>
      </tr>
          ";
        }
        echo "</table>";
        break;

      case 'date':
	//Вывод по дате
	$moduleQ = loadMaxQuestionQuant($date, $conn, 'date');
	if(isset($moduleQ['errors'])){
		echo $moduleQ['errors'];
		die();
	}

        echo "
        <div class='data-preview'>
          Таблица результатов за ".$date."
        </div>
        <br>
        <table id='table-1'>
          <tr>
            <th onclick='sortTable(0)'> ФИО студента </th>
            <th onclick='sortTable(1)'> Класс </th>
            <th onclick='sortTable(2)'> Модуль </th>
	    <th onclick='sortTable(3)'> Дата выполнения </th>";
	    for($i=1; $i<$moduleQ['qnum']+1; $i++){
	    	echo"<th onclick='sortTable(".($i+3).")' >$i</th>";
	    }
				  echo"
    	    <th> Действия </th>
          </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['student']." </td>
            <td> ".$row['class']."</td>
            <td> ".$row['module']." </td>
	    			<td> ".$row['date']." </td>";
	  			  loadModuleAnswersTable($row['id'],$conn, $moduleQ['qnum']);
          echo"
	    			<td style='display:flex'>
	   	    	<a style='width: 50%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'> Смотреть результат </a>
						<a style='width: 50%' href='#' onclick='showSimilar(".$row['id'].")'> Смотреть похожее </a>  </td>
          </tr>
          ";
        }
        echo "</table>";
        break;

      case 'student':
	//За студента
	$moduleQ = loadMaxQuestionQuant($student, $conn, 'student');
	if(isset($moduleQ['errors'])){
		echo $moduleQ['errors'];
		die();
	}
        echo "
        <div class='data-preview'>
          Таблица результатов обучающегося ".$student."
        </div>
        <br>
        <table id='table-1'>
          <tr>
            <th onclick='sortTable(0)'> Модуль </th>
            <th onclick='sortTable(1)'> Дата выполнения </th>
	    ";
	for($i=1; $i<$moduleQ['qnum']+1; $i++){
		echo"<th onclick='sortTable(".($i+1).")' >$i</th>";
	}
	echo"<th> Действия</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['module']." </td>
	    <td> ".$row['date']." </td>";
	loadModuleAnswersTable($row['id'], $conn, $moduleQ['qnum']);
 	  echo"
	    <td style='display:flex'>
		<a style='width: 50%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'> Смотреть результат </a>
		<a style='width: 50%' href='#' onclick='showSimilar(".$row['id'].")'> Смотреть похожее </a>
	    </td>
          </tr>
          ";
        }
        echo "</table>";
        break;

      case 'all':
	//Все резултаты
	$moduleQ = loadMaxQuestionQuant('all', $conn);
	if(isset($moduleQ['errors'])){
		echo $moduleQ['errors'];
		die();
	}
	echo "
        <div class='data-preview'>
          Полная таблица результатов
        </div>
        <br>
        <table id='table-1'>
          <tr>
            <th onclick='sortTable(0)'> ФИО студента </th>
            <th onclick='sortTable(0)'> Класс </th>
            <th onclick='sortTable(0)'> Модуль </th>
	    <th> Дата выполнения </th>";
	for($i=1; $i<$moduleQ['qnum']+1; $i++){
		echo"<th onclick='sortTable(".($i+2).")' style='width:40px;'>$i</th>";
	}
	echo"<th> Действия </th>
          </tr>
        ";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "
          <tr>
            <td> ".$row['student']." </td>
            <td> ".$row['class']."</td>
            <td> ".$row['module']." </td>
            <td> ".$row['date']." </td>
	";
	loadModuleAnswersTable($row['id'], $conn, $moduleQ['qnum']);
	echo"
	    <td style='display:flex'>
		<a style='width: 50%' class='veiwlink' href='viewresult.php?td=tr_".$row['id']."' target='_blank'> Смотреть результат </a>
		<a style='width: 50%' href='#' onclick='showSimilar(".$row['id'].")'> Смотреть похожее </a>
	    </td>
          </tr>
          ";
        }
        echo "</table>";
      break;
    }
	// echo "<br> <p> <a class='tabling' href='php/functions/export.php'> Экспортировать данную таблицу </a> </p>";
  } else {
    echo "По данному запросу отсутсвуют результаты";
  }
} else {
  echo "Что-то пошло не так $sql";
}
?>
