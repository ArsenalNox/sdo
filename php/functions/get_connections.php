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
        switch($status){
            case 0:
                echo "
                <p class='ip' style='text-transform: uppercase'> <button class='button3' onclick='ConfirmStudent($id)'> Подтвердить </button> $ip : $uid, $grp<p>
                ";
                break;
            case 1:
                echo "
                <p class='ip' style='text-transform: uppercase'> <button  class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтвердить </button> $ip : $uid, $grp</p>
                ";
                break;
        }
    }
} else {
    echo "Пока никого нету";
}
