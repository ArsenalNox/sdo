<?php
//Показ всех вопросов выбранного модуля
// TODO: Функция выбора показа конкретного варианта

include_once "../../dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $module = $_POST['module_name'];
  $sql = "SELECT * FROM new_module WHERE Name = '$module' ;";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($result);
  $path = $data['Questions'];
  if(file_get_contents("../../$path")){
    $string = file_get_contents("../../$path");
  } else {
    echo "<h3> Ошибка: Не получилось открыть файл модуля </h3>";
    die();
  }

  // QUESTION: Надо ли фильтр по вариантам
  // echo "<select onselect='ShowSpecificVariants()' id='varsel'>
  // <option value='0'> Показать все варианты       </option>
  // <option value='1'> Показывать только вариант 1 </option>
  // <option value='2'> Показывать только вариант 2 </option>
  // <option value='3'> Показывать только вариант 3 </option>
  // <option value='4'> Показывать только вариант 4 </option>
  // <option value='5'> Показывать только вариант 5 </option>
  // </select>" ;

  $i = 0; //  кол-во итераций в JSON'е модуля
  $showmeta = true; //Флаг показа мета информации

  $json_a = json_decode($string, true);
  foreach ($json_a as $struct => $quest) { //Проходимся по всем эелементам JSON'а
    if($showmeta){
      //Показываем мету
      $showmeta=false;
      if(isset($quest['Module_name'])){
        echo "<p> Название модуля: ". $quest['Module_name'] ." </p>"; }
      if(isset($quest['quest_quantity'])){
        $quest_quantity = $quest['quest_quantity'];
        echo "<p> Кол-во вопросов: ".$quest['quest_quantity']."</p>"; }
      continue;
    }

    $i++;
    if($quest['IMAGE'] == ''){ //Если у вопроса есть картинка
      $image = '';
    } else {
      $image = "<figure><img src='/sdo/".$quest['IMAGE']."'></figure>";
      if(strpos($quest['QUESTION'], "{<image>}") !== false){ //Если присутвтует тэг точного расположения
      	$quest['QUESTION'] = str_replace('{<image>}', $image, $quest['QUESTION']); //заменить тэг на изображение
        $image = '';
      }
    }


    echo "
	<div class='task' id='n".$quest['QUESTION_NUM']."-v".$quest['VAR']."-".$quest['QUESTION_NUM']."'>
	<h4> Задание №".$quest['QUESTION_NUM']."
	Вариант ".$quest['VAR']."
	$image
	</h4> ".$quest['QUESTION']." <br>
    ";

    //Вывод вариантов ответа
    if(isset($quest['A'])){
      echo "  A) " . $quest['A'] . ";<br>";
    }
    if(isset($quest['B'])){
      echo "  B) " . $quest['B'] . ";<br>";
    }
    if(isset($quest['C'])){
      echo "  C) " . $quest['C'] . ";<br>";
    }
    if(isset($quest['D'])){
      echo "  D) " . $quest['D'] . ";<br>";
    }
    if(isset($quest['E'])){
      echo "  E) " . $quest['E'] . ";<br>";
   }

    echo "<br> <b> Правильный ответ: " . $quest['CORRECT'] . " </b>
    <hr> </div>";
  }
  echo "
    <p> Всего вопросов: $quest_quantity, не учитывая варианты, <span id='qnum'>$i</span> учитывая</p>
    Время на выполнение в минутах: 45 <br> <input type='hidden' name='time' placeholder='45' value='45' style='width:40px;' id='test_time'>
    <br>
    <button class='nexttest' type='button' name='button' onclick='StartTest()' >Начать тест</button>
    ";
}
?>
