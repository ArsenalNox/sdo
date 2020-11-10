<?php
//Вывод дополнительныъ опций поиска в зависимости от выбранного основного критерия поиска
include_once "../../dtb/dtb.php";

switch ($_POST['data']) {
  case 'module':
    echo "
    <input type='hidden' name='option-count' id='oc' value='3'>

    <div class='option-wrap'> <p onclick='showOption(1)'> Показывать только результаты ученика </p>
      <div class='option' id='opt1'>
        <input class='stsrch' type='search' list='student-dataset' id='ao1' name='addl-student' placeholder='Имя студента'>
        <input type='hidden' id='optstate1' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(2)'> Показывать только результаты класса </p>
      <div class='option' id='opt2'>
        <input class='stsrch' type='search' list='class-dataset' id='ao2' name='addl-class' placeholder='Класс'>
        <input type='hidden' id='optstate2' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(3)'> Показывать результаты за день </p>
      <div class='option' id='opt3'>
        <input class='stsrch' type='date' id='ao3' name='addl-date' placeholder='Дата'>
        <input type='hidden' id='optstate3' value='hidden'>
      </div>
    </div>
    ";
    break;
  case 'class':
    echo "
    <input type='hidden' name='option-count' id='oc' value='3'>

    <div class='option-wrap'> <p onclick='showOption(1)'> Показывать только результаты ученика </p>
      <div class='option' id='opt1'>
        <input class='stsrch' type='search' list='student-dataset' id='ao1' name='addl-student' placeholder='Имя студента'>
        <input type='hidden' id='optstate1' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(2)'> Показывать результаты за день </p>
      <div class='option' id='opt2'>
        <input class='stsrch' type='date' id='ao2' name='addl-date'>
        <input type='hidden' id='optstate2' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(3)'> Показывать результаты по модулю </p>
      <div class='option' id='opt3'>
        <input class='stsrch' type='search' list='module-dataset' id='ao3' name='addl-module' placeholder='Модуль'>
        <input type='hidden' id='optstate3' value='hidden'>
      </div>
    </div>
    ";
    break;
  case 'date':
    echo "
    <input type='hidden' name='option-count' id='oc' value='3'>

    <div class='option-wrap'> <p onclick='showOption(1)'> Показывать только результаты ученика </p>
      <div class='option' id='opt1'>
        <input class='stsrch' type='search' list='student-dataset' id='ao1' name='addl-student' placeholder='Имя студента'>
        <input type='hidden' id='optstate1' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(2)'> Показывать только результаты класса </p>
      <div class='option' id='opt2'>
        <input class='stsrch' type='search' list='class-dataset' id='ao2' name='addl-class' placeholder='Класс'>
        <input type='hidden' id='optstate2' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(3)'> Показывать результаты по модулю </p>
      <div class='option' id='opt3'>
        <input class='stsrch' type='search' list='module-dataset' id='ao3' name='addl-module' placeholder='Модуль'>
        <input type='hidden' id='optstate3' value='hidden'>
      </div>
    </div>
    ";
    break;
  case 'student':
    echo "
    <input type='hidden' name='option-count' id='oc' value='3'>

    <div class='option-wrap'> <p onclick='showOption(1)'> Показывать результаты за день </p>
      <div class='option' id='opt1'>
        <input class='stsrch' type='date' id='ao1' name='addl-date'>
        <input type='hidden' id='optstate1' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(2)'> Показывать только результаты класса </p>
      <div class='option' id='opt2'>
        <input class='stsrch' type='search' list='class-dataset' id='ao2' name='addl-class' placeholder='Класс'>
        <input type='hidden' id='optstate2' value='hidden'>
      </div>
    </div>

    <div class='option-wrap'> <p onclick='showOption(3)'> Показывать результаты по модулю </p>
      <div class='option' id='opt3'>
        <input class='stsrch' type='search' list='module-dataset' id='ao3' name='addl-module' placeholder='Модуль'>
        <input type='hidden' id='optstate3' value='hidden'>
      </div>
    </div>
    ";
    break;

    case 'all':
      echo "
      <input type='hidden' name='option-count' id='oc' value='3'>

      <div class='option-wrap'> <p onclick='showOption(1)'> Показывать результаты за день </p>
        <div class='option' id='opt1'>
          <input class='stsrch' type='date' id='ao1' name='addl-date'>
          <input type='hidden' id='optstate1' value='hidden'>
        </div>
      </div>

      <div class='option-wrap'> <p onclick='showOption(2)'> Показывать только результаты класса </p>
        <div class='option' id='opt2'>
          <input class='stsrch' type='search' list='class-dataset' id='ao2' name='addl-class' placeholder='Класс'>
          <input type='hidden' id='optstate2' value='hidden'>
        </div>
      </div>

      <div class='option-wrap'> <p onclick='showOption(3)'> Показывать результаты по модулю </p>
        <div class='option' id='opt3'>
          <input class='stsrch' type='search' list='module-dataset' id='ao3' name='addl-module' placeholder='Модуль'>
          <input type='hidden' id='optstate3' value='hidden'>
        </div>
      </div>
      ";
      break;
}
?>
