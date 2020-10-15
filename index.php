<?php
    include_once "dtb/dtb.php";
    $ip = $_SERVER['REMOTE_ADDR'];
    //получение статуса ученика
    echo "IP address = $ip ";
    $sql = "SELECT * FROM connectons WHERE ip = '$ip';";
    $result = mysqli_query($conn, $sql);
    $status = 0;
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];
        $uid = $row['student_uid'];
        echo ' Статус' . $status;
    } else {
        if(!isset($uid)){
            $uid = '';
        }
        $sql = "INSERT INTO connectons (ip, student_uid) VALUES ('$ip', '$uid') ;";
        $insert = mysqli_query($conn, $sql);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/student.css">
    <meta charset="UTF-8">>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СДО</title>
    <style>
        #get_name{
            width: 224px;
        }
    </style>
</head>
<body>
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/student.js"></script>

    <section class="student-wrapper">

        <div class="selection" id='sg1'>
                Выберите класс:
                <select name="get_group" id="student_group_selector" class="get_group" onchange="GetGroupNames()">
                    <?php
                        $sql = "SELECT * FROM group_student";
                        $result = mysqli_query($conn, $sql);
                        echo "<option>--</option>";
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $name = $row['NAME'];
                                $id = $row['ID'];
                                echo "<option value=$id>$name</option>";
                            }
                        }
                    ?>
                </select>
                <select name="get_name" id="group_names" class="get_name">
                    <option value=''> --Выберите Класс-- </option>";
                </select>
                <button type="submit" class="button" onclick='SendStudentInfo()'>Отправить</button>
        </div>

        <div class="student-info">
            <?php  if($status == true){
               echo "Вы подтверждены как: $uid
               <script> document.getElementById('sg1').style.display = 'none' </script>";
            }
            else {
               echo "Ожидание подтверждения";
             } ?>
        </div>
        <br>


    </section>


</body>
</html>
