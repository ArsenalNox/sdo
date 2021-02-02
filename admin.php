<?php
require_once 'dtb/dtb_funcs.php';
$groups = dbquery('SELECT * FROM group_student');
?>

<form action="">
    <select name="GROUP_STUDENT_ID">
        <option value="null" selected disabled>Выберите класс</option>
        <?php foreach($groups as $group): ?>
          <option value="<?=$group['ID']?>"><?=$group['NAME']?></option>
        <?php endforeach; ?>
    </select>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Введите Имя">
        <input name="LAST_NAME" type="text" placeholder="Введите Фамилию">
        <input name="MIDDLE_NAME" type="text" placeholder="Введите Отчество">

    </div>
</form>
