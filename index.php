<?php
    include_once "dtb/dtb.php";
    $ip = $_SERVER['REMOTE_ADDR'];
    //получение статуса ученика
    echo "<p style='display:none;' id='ip'>$ip</p>";
    $sql = "SELECT * FROM connectons WHERE ip = '$ip';";
    $result = mysqli_query($conn, $sql);
    $status = 0;
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];
        $group = $row['group_nl'];
        $uid = $row['student_uid'];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СДО</title>
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
               echo "Вы подтверждены как: $uid, <span id='student_group'>$group</span>
               <script>
               document.getElementById('sg1').style.display = 'none'
               LoadTests()
               </script>";
            }
            else {
               echo "Ожидание подтверждения как $uid  ";
             } ?>
        </div>
        <br>
        <div class="main-testfield" id='mtf'>
        </div>

    </section>


</body>
</html>
