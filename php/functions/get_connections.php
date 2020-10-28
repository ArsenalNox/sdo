<?php
//Получение сединений
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

        switch ( $row['test_status']) {
          case 'test_not_selected':
              $test_status = 'Не выбрал тест';
            break;

          case 'test_started':
              $test_status = 'Проходит тест';
            break;

          case 'completed':
              $test_status = 'Завершил тест';
            break;

        }

        if($status == 0){echo "<div class='student-ip-info'> <button class='button3' onclick='ConfirmStudent($id)'> Подтвердить </button>";
        } else {echo "<div class='student-ip-info'> <button class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтверждён </button>";}

        echo "<p class='ip' style='text-transform: uppercase'> $ip : $uid, $grp <p> <p> Статус: $test_status </p> <hr> </div>";

        // switch($status){
        //     case 0:
        //         echo "
        //         <p class='ip' style='text-transform: uppercase'> <button class='button3' onclick='ConfirmStudent($id)'> Подтвердить </button> $ip : $uid, $grp<p>
        //         ";
        //         break;
        //     case 1:
        //         echo "
        //         <p class='ip' style='text-transform: uppercase'> <button class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтвердить </button> $ip : $uid, $grp</p>
        //         ";
        //         break;
        // }
    }
} else {
    echo "Пока никого нету";
}
