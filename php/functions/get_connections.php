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
        $id = $row['id'];
        switch($status){
            case 0:
                echo "
                <p> <button onclick='ConfirmStudent($id)'> Подтвердить </button> $ip : $uid <p>
                ";
                break;
            case 1:
                echo "
                <p> <button class='confirmed-button' onclick='DeconfirmStudent($id)'> Подтвердить </button> $ip : $uid </p>
                ";
                break;
        }
    }
} else {
    echo "Пока никого нету";
}
