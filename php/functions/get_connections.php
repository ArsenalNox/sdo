<?php
//Получение сединений

// TODO: Добавить цветовое отображение статуса теста у ученика
// DONE: Добавить возможность смотреть результат теста преподавателю (через панель устройств)

include_once "../../dtb/dtb.php";
$sql = "SELECT * FROM connectons;";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    while($row = $result->fetch_assoc()){
        $ip = $row['ip'];
        $status = $row['status'];
        $uid = $row['student_uid'];
        $grp = $row['group_nl'];
        $id = $row['id'];
        if($row['test_id'] == ''){
          $test_dir = '';
        } else {
          $test_dir = "<br><a href='viewresult.php?td=" . $row['test_id'] . "'> Смотреть результат последненго завершенного теста   </a>";
        }
        switch ($row['test_status']) {
          case 'test_not_selected':
              $test_status = 'Не выбрал тест'. $test_dir;
            break;

          case 'test_started':
              $test_status = 'Проходит тест'.$test_dir;
            break;

          case 'completed':
              $test_status = 'Завершил тест'.$test_dir;
            break;

          default:
              $test_status = '';
            break;
        }

        if($status == 0){echo "<div class='student-ip-info'> <button class='button3' onclick='ConfirmStudent($id)'> Подтвердить </button>";
        } else {echo "<div class='student-ip-info'> <button class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтверждён </button>";}

        echo "<p class='ip'> $ip : $uid, $grp </p> ";
        if(!($test_status == '')){
          echo "<p> Статус: $test_status </p> <hr> </div>";
        } else {
          echo "<hr> </div>";
        }
    }
} else {
    echo "Пока никого нету";
}
