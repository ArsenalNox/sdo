<?php
require_once 'dtb/dtb_funcs.php';
$groups = dbquery('SELECT * FROM group_student');

if(isset($_POST['students']) && isset($_POST['group']))
{
  $students = json_decode($_POST['students'], true);;
  $group_id = $_POST['group'];
  foreach($students as $student)
  {
    $sql = "INSERT INTO `student` (`NAME`, `LAST_NAME`, `MIDDLE_NAME`, `GROUP_STUDENT_ID`) VALUES ('".$student['fname']."', '".$student['lname']."', '".$student['mname']."', '".$group_id."')";
    dbexecute($sql);
  }
  exit(json_encode(['type' => 'success', 'data' => 'Круть!']));
}
?>
<link rel="stylesheet" href="css/admin.css">
<form action="" method="POST">
    <select name="GROUP_STUDENT_ID">
        <option value="null" selected disabled>Выберите класс</option>
        <?php foreach($groups as $group): ?>
          <option value="<?=$group['ID']?>"><?=$group['NAME']?></option>
        <?php endforeach; ?>
    </select>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">

    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <div class="item">
        <input name="NAME" type="text" placeholder="Имя">
        <input name="LAST_NAME" type="text" placeholder="Фамилия">
        <input name="MIDDLE_NAME" type="text" placeholder="Отчество">
    </div>
    <button type="submit">Загрузить</button>
</form>

<script src="js/fetch_admin.js"></script>
