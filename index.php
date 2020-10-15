<?php
    include_once "dtb/dtb.php";
    $ip=$_SERVER['REMOTE_ADDR'];
    echo "IP address= $ip";
    $sql = "SELECT * FROM connectons WHERE ip = '$ip';";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        
        $row = $result->fetch_assoc();
        $status = $row['status'];
        $uid = $row['student_uid'];
        echo ' Уже есть   ' . $status;
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СДО</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="js/get_name.js"></script>
    <style>
        #get_name{
            width: 224px;
        }
    </style>
</head>
<body>
    <section class="student-wrapper">
       
        <div class="intro">
            <h2> <b>НАПИШИТЕ ВЫБОР МОДУЛЯ </b> </h2>
        </div>
        <marquee direction="right"><h1>модуль....</h1></marquee>
        <div class="student-info">
            <?php  if($status == true){ echo "Вы подтверждены как: $uid";    }else{ echo "Ожидание подтверждения"; } ?>
        </div>
        <br>
        <div class="form">
                <select name="get_group" id="get_group" class="get_group">
                    <?php
                        $sql = "select * from group_student";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            echo "<option value=0>--Выберите группу--</option>";
                            while($row = mysqli_fetch_assoc($result)){
                                $name = $row['NAME'];
                                $id = $row['ID'];
                                echo "<option value=$id>$name</option>";
                            }
                        }
                    ?>
                </select>
                <select name="get_name" id="get_name" class="get_name">
                    <option value=''>--Выберите группу--</option>";
                </select>
                
                <button type="submit" class="button">Отправить</button>
        </div>
    </section>
</body>
</html>