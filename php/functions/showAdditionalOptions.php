<?php
include_once "../../dtb/dtb.php";

switch ($_POST['data']) {
  case 'module':
    echo "
    <div class='option'>
    <label for='search-student'> Показывать только результаты ученика: </label>
    <input class='stsrch' type='search' list='student-dataset' id='search-student' name='add-student' placeholder='Имя студента'>
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
