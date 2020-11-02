<?php
include_once ",,/,,/dtb/dtb.php";

switch ($_POST['data']) {
  case 'module':
    echo "
    <option value=''>  </option>
    ";
    break;
  case 'class':
    echo "
    <option>
    опции класса
    </option>
    ";
    break;
  case 'date':
    echo "
    <option>
    опции даты
    </option>
    ";
    break;
  case 'student':
    echo "
    <option>
    опции студента
    </option>
    ";
    break;

}

echo "<option value=''> --Не использовать дополнительных опций-- </option>";

?>
