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
  $showmeta = true;
  // echo "<select onselect='ShowSpecificVariants()' id='varsel'>
  // <option value='0'> Показать все варианты       </option>
  // <option value='1'> Показывать только вариант 1 </option>
  // <option value='2'> Показывать только вариант 2 </option>
  // <option value='3'> Показывать только вариант 3 </option>
  // <option value='4'> Показывать только вариант 4 </option>
  // <option value='5'> Показывать только вариант 5 </option>
  // </select>
  // " ;
  foreach ($json_a as $struct => $quest) {
    if($showmeta){
      $showmeta=false;
      $quest_quantity = $quest['quest_quantity'];
      echo "
      <p> Название модуля: ". $quest['Module_name'] ." </p>
      <p> Кол-во вопросов: ".$quest['quest_quantity']."</p>
      ";
      continue;
    }
    $i++;
    if($quest['IMAGE'] == ''){
      $image = '';
    } else {
      $image = "<img src='/sdo".$quest['IMAGE']."'>";
    }
    switch ($quest['NUM_ANSW']) {
      case '2':
        echo
          "<div class='task' id='n" . $quest['QUESTION_NUM'] . "-v" . $quest['VAR'] . "-" . $quest['QUESTION_NUM'] . "'>
          <h4> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . " $image
          </h4> " . $quest['QUESTION'] . " <br>
          A) " . $quest['A'] . " ;
          B) " . $quest['B'] . " ;
          <br> <b> Правильный ответ: " . $quest['CORRECT'] . " </b>
          <hr> </div>";
        break;
      case '3':
        echo
          "<div class='task' id='n" . $quest['QUESTION_NUM'] . "-v" . $quest['VAR'] . "'>
          <h4> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . " $image
          </h4> " . $quest['QUESTION'] . " <br>
          A) " . $quest['A'] . " ;
          B) " . $quest['B'] . " ;
          C) " . $quest['C'] . " ;
          <br> <b> Правильный ответ: " . $quest['CORRECT'] . " </b>
          <hr> </div>";
        break;
      case '4':
        echo
          "<div class='task' id='n" . $quest['QUESTION_NUM'] . "-v" . $quest['VAR'] . "'>
          <h4> Задание №" . $quest['QUESTION_NUM'] . "
          Вариант " . $quest['VAR'] . " $image
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
  // for ($j=1; $j < $quest_quantity+1; $j++) {
  //     echo '
  //     <p> Задание '. $j .' </p>
  //    <input type="radio" id="'.$j.'" name="testn'.$j.'" value="1">
  //    <label for="male">ВКЛ</label>
  //    <input type="radio" id="'.$j.'" name="testn'.$j.'" value="0">
  //    <label for="female">ВЫКЛ</label>
  //    <br>
  //    ';
  // }
  echo "
    <p> Всего вопросов: $quest_quantity, не учитывая варианты, <span id='qnum'>$i</span> учитывая</p>
    Время на выполнение в минутах <input type='number' name='time' placeholder='45' style='width:40px;' id='test_time'>
    <br>
    <button type='button' name='button' onclick='StartTest()' >Начать тест</button>
    ";
}
?>
