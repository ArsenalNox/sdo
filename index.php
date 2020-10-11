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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СДО</title>
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


    </section>  



</body>
</html>