<?php
include_once "../../dtb/dtb.php";

switch ($_POST['data']) {
  case 'module':
    echo "
    <input type='hidden' name='option-count' id='oc' value='2'>
    <div class='option-wrap'> <p onclick='showOption(1)'> Опция 1 </p>
      <div class='option' id='opt1'>
        <label for='search-student'> Показывать только результаты ученика: </label>
        <input class='stsrch' type='search' list='student-dataset' id='ao1' name='addl-student' placeholder='Имя студента'>
        <input type='hidden' id='optstate1' value='hidden'>
      </div>
    </div>
    <div class='option-wrap'> <p onclick='showOption(2)'> Опция 2 </p>
      <div class='option' id='opt2'>
        <label for='search-student'> Показывать только результаты класса: </label>
        <input class='stsrch' type='search' list='class-dataset' id='ao2' name='addl-class' placeholder='Класс'>
        <input type='hidden' id='optstate2' value='hidden'>
      </div>
    </div>";
    break;
  case 'class':
    echo "

    ";
    break;
  case 'date':
    echo "
    ";
    break;
  case 'student':
    echo "
    ";
    break;
}
?>
