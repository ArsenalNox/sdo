<?php
//Показ всех вопросов выбранного модуля
include_once "../../dtb/dtb.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $module = $_POST['module_name'];
  $sql = "SELECT * FROM new_module WHERE Name = '$module' ;";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_assoc($result);
  $path = $data['Questions'];
  $string = file_get_contents("../../$path");
  $json_a = json_decode($string, true);
  $i = 0;
  echo "<select onselect='ShowSpecificVariants()' id='varsel'>
  <option value='0'> Показать все варианты       </option>
  <option value='1'> Показывать только вариант 1 </option>
  <option value='2'> Показывать только вариант 2 </option>
  <option value='3'> Показывать только вариант 3 </option>
  <option value='4'> Показывать только вариант 4 </option>
  <option value='5'> Показывать только вариант 5 </option>
  </select>
  " ;
  foreach ($json_a as $struct => $quest) {
    $i++;
    $quest_quantity = $quest['QUESTION_NUM'];
    switch ($quest['NUM_ANSW']) {
      case '2':
        echo
          "<div class='task' id='v" . $quest['VAR'] . "-" . $quest['QUESTION_NUM'] . "'>
          <h4> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . "
          </h4> " . $quest['QUESTION'] . " <br>
          A) " . $quest['A'] . " ;
          B) " . $quest['B'] . " ;
          <br> <b> Правильный ответ: " . $quest['CORRECT'] . " </b>
          <hr> </div>";
        break;
      case '3':
        echo
          "<div class='task' id='v" . $quest['VAR'] . "'>
          <h4> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . "
          </h4> " . $quest['QUESTION'] . " <br>
          A) " . $quest['A'] . " ;
          B) " . $quest['B'] . " ;
          C) " . $quest['C'] . " ;
          <br> <b> Правильный ответ: " . $quest['CORRECT'] . " </b>
          <hr> </div>";
        break;
      case '4':
        echo
          "<div class='task' id='v" . $quest['VAR'] . "'>
          <h4> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . "
          </h4> " . $quest['QUESTION'] . " <br>
          A) " . $quest['A'] . " ;
          B) " . $quest['B'] . " ;
          C) " . $quest['C'] . " ;
          D) " . $quest['D'] . "
          <br> <b> Правильный ответ: " . $quest['CORRECT'] . " </b>
          <hr> </div>";
        break;
    }
  }
  echo "
    <p> Всего вопросов $quest_quantity не учитывая варианты, <span id='qnum'>$i</span> учитывая</p>
    <button type='button' name='button' onclick='StartTest()'>Начать тест</button>
    ";
}
?>
